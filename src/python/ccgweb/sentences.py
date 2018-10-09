import ccgweb
import ccgweb.assignments
import ccgweb.users
import ccgweb.util
import falcon
import hashlib
import json
import os
import subprocess


class Sentence:

    def on_get(self, req, res, lang, sentence):
        # Preliminaries:
        sentence = ccgweb.util.fix_encoding(sentence)
        user = ccgweb.users.current_user(req)
        if not user:
            user = 'auto'
        body = {}
        # Assignment:
        assignment = ccgweb.assignments.get_assignment(user)
        for i, s in enumerate(assignment):
            if s['sentence'] == sentence:
                if i > 0:
                    for preceding_sentence in assignment[i - 1::-1]:
                        if not preceding_sentence['done']:
                            body['prev'] = preceding_sentence
                            break
                if i + 1 < len(assignment):
                    for following_sentence in assignment[i + 1:]:
                        if not following_sentence['done']:
                            body['next'] = following_sentence
                            break
                break
        # Annotations
        annotators = get_annotators(lang, sentence)
        human_annotators = set(annotators)
        human_annotators.discard('auto')
        human_annotators.discard('testuser')
        human_annotators.discard('proj')
        human_annotators.discard('xl')
        human_annotators.discard('judge')
        body['needs_annotation'] = len(human_annotators) < 2
        if user == 'auto':
            versions = set(('auto',))
        elif user == 'testuser':
            versions = set(('auto', user))
        elif user == 'judge':
            versions = set(annotators)
            versions.add('auto')
            versions.add('judge')
        else:
            if 'judge' in annotators:
                versions = set(human_annotators)
                versions.add('auto')
                versions.add(user)
                versions.add('judge')
            else:
                versions = set(('auto', user))
        versions = sorted(versions, key=annotator_sort_key)
        body['annotations'] = []
        for version in versions:
            derxml, marked_correct = get_contents(lang, sentence, version, 'der.xml')
            body['annotations'].append({'user_id': version, 'derxml': derxml,
                                        'marked_correct': marked_correct})
        # Translations
        body['translations'] = get_translations(lang, sentence, user)
        # Comment
        body['comment'] = get_comment(lang, sentence, user)
        # Return
        res.content_type = 'application/json'
        res.body = json.dumps(body)

    def on_post(self, req, res, lang, sentence):
        sentence = ccgweb.util.fix_encoding(sentence)
        if 'api_action' not in req.params:
            res.status = falcon.HTTP_400
            return
        if req.params['api_action'] == 'add_super_bow':
            user = ccgweb.users.current_user(req)
            if not user:
                res.status = falcon.HTTP_401
                return
            sentence_hash = sentence2hash(sentence)
            try:
                offset_from = int(req.params['offset_from'])
                offset_to = int(req.params['offset_to'])
                tag = req.params['tag']
            except (KeyError, ValueError):
                res.status = falcon.HTTP_400
                return
            ccgweb.db.execute('''INSERT INTO bows_super
                (user_id, time, lang, sentence_id, offset_from, offset_to, tag)
                VALUES (%s, NOW(), %s, %s, %s, %s, %s)''', user, lang,
                sentence_hash, offset_from, offset_to, tag)
        elif req.params['api_action'] == 'add_span_bow':
            user = ccgweb.users.current_user(req)
            if not user:
                res.status = falcon.HTTP_401
                return
            sentence_hash = sentence2hash(sentence)
            try:
                offset_from = int(req.params['offset_from'])
                offset_to = int(req.params['offset_to'])
            except (KeyError, ValueError):
                res.status = falcon.HTTP_400
                return
            ccgweb.db.execute('''INSERT INTO bows_span
                (user_id, time, lang, sentence_id, offset_from, offset_to)
                VALUES (%s, NOW(), %s, %s, %s,%s)''', user, lang, sentence_hash,
                offset_from, offset_to)
        elif req.params['api_action'] == 'mark_correct':
            user = ccgweb.users.current_user(req)
            if not user:
                res.status = falcon.HTTP_401
                return
            sentence_hash = sentence2hash(sentence)
            try:
                correct = req.params['correct'] == 'true'
            except KeyError:
                res.status = falcon.HTTP_400
                return
            if correct:
                with open(get_path(lang, sentence_hash, user, 'der.xml'), 'rb') as f:
                    derxml = f.read()
                with open(get_path(lang, sentence_hash, user, 'parse.tags'), 'rb') as f:
                    parse = f.read()
                ccgweb.db.execute('''INSERT INTO correct
                    (lang, sentence_id, user_id, time, derxml, parse)
                    VALUES (%s, %s, %s, NOW(), %s, %s)
                    ON DUPLICATE KEY UPDATE
                    time = NOW(), parse = %s''', lang, sentence_hash,
                    user, derxml, parse, parse)
            else:
                ccgweb.db.execute('''DELETE FROM correct
                    WHERE lang = %s
                    AND sentence_id = %s
                    AND user_id = %s''', lang, sentence_hash, user)
        elif req.params['api_action'] == 'reset':
            user = ccgweb.users.current_user(req)
            if not user:
                res.status = falcon.HTTP_401
                return
            sentence_hash = sentence2hash(sentence)
            ccgweb.db.execute('''DELETE FROM correct
                WHERE lang = %s
                AND sentence_id = %s
                AND user_id = %s''', lang, sentence_hash, user)
            ccgweb.db.execute('''DELETE FROM bows_span
                WHERE lang = %s
                AND sentence_id = %s
                AND user_id = %s''', lang, sentence_hash, user)
            ccgweb.db.execute('''DELETE FROM bows_super
                WHERE lang = %s
                AND sentence_id = %s
                AND user_id = %s''', lang, sentence_hash, user)
            ccgweb.db.execute('''DELETE FROM bows_tok
                WHERE lang = %s
                AND sentence_id = %s
                AND user_id = %s''', lang, sentence_hash, user)
        elif req.params['api_action'] == 'set_comment':
            user = ccgweb.users.current_user(req)
            if not user:
                res.status = falcon.HTTP_401
                return
            sentence_hash = sentence2hash(sentence)
            try:
                text = req.params['text']
            except KeyError:
                text = ''
            ccgweb.db.execute('''INSERT INTO comment
                (lang, sentence_id, user_id, time, text)
                VALUES (%s, %s, %s, NOW(), %s)
                ON DUPLICATE KEY UPDATE time = NOW(), text = %s''', lang, sentence_hash, user, text, text)
        else:
            res.status = falcon.HTTP_400
            return


def sentence2hash(sentence):
    # Deprecated, use sentid instead.
    if not sentence.endswith('\n'):
        sentence += '\n'
    return hashlib.sha1(sentence.encode('UTF-8')).hexdigest()


def sentid(sentence):
    """Returns the canonicalized form of a sentence and its ID.

    Given as a pair (sentence, sentence_id). Canonicalized means that all
    trailing whitespace is replaced by a single LF character.
    """
    sentence = sentence.rstrip() + '\n'
    hsh = hashlib.sha1(sentence.encode('UTF-8')).hexdigest()
    return sentence, hsh
    

def get_raw_path(lang, sentence_hash):
    raw_dir = os.path.join('raw', lang, sentence_hash[:2])
    return os.path.join(raw_dir, '.'.join((sentence_hash, 'raw')))


def get_path(lang, sentence_hash, user, extension):
    out_dir = os.path.join('out', lang, sentence_hash[:2], sentence_hash)
    return os.path.join(out_dir, '.'.join((user, extension)))


def get_proj_path(lang, target_sentence_hash, source_sentence_hash, portion,
    extension):
    if portion not in ('train', 'traindevtest'):
        raise ValueError('portion must be one of train, traindevtest')
    target_sentence_dir = os.path.join('out', lang, target_sentence_hash[:2],
        target_sentence_hash)
    projection_dir = os.path.join(target_sentence_dir, 'proj',
        source_sentence_hash)
    return os.path.join(projection_dir, 'proj-' + portion + '.' + extension)


def get_contents(lang, sentence, user, extension):
    """Get the data for a specific annotation layer for some user.

    Returns a tuple (contents, marked_correct) where contents is the data as
    a string and marked_correct is boolean.
    """
    sentence, sentence_hash = sentid(sentence)
    rows = ccgweb.db.get('''SELECT derxml
        FROM correct
        WHERE lang = %s
        AND sentence_id = %s
        AND user_id = %s''', lang, sentence_hash, user)
    if rows:
        return (rows[0][0], True)
    else:
        # Make sure raw file exists:
        raw_path = get_raw_path(lang, sentence_hash)
        if not os.path.isfile(raw_path):
            ccgweb.util.makedirs(os.path.split(raw_path)[0])
            with open(raw_path, 'w', encoding='UTF-8') as f:
                f.write(sentence)
        # Process the document:
        derxml_path = get_path(lang, sentence_hash, user, 'der.xml')
        subprocess.check_call(('./ext/produce/produce', derxml_path))
        with open(derxml_path, 'r') as f:
            return (f.read(), False)


def get_translations(lang, sentence, user):
    sentence, sentence_hash = sentid(sentence)
    rows = ccgweb.db.get('''SELECT DISTINCT t.lang, t.sentence, c.time IS NOT NULL AS done
        FROM sentence_links AS l
        INNER JOIN sentences AS t ON l.lang2 = t.lang AND l.id2 = t.sentence_ID
        LEFT OUTER JOIN correct AS c ON l.lang2 = c.lang AND l.id2 = c.sentence_id AND c.user_id = %s
        WHERE l.lang1 = %s
        AND l.id1 = %s
        AND t.assigned = 1''', user, lang, sentence_hash)
    return [{'lang': lang, 'sentence': sentence.rstrip(), 'done': bool(done)}
            for lang, sentence, done in rows]


def get_annotators(lang, sentence):
    """Returns the list of users who have annotated this sentence."""
    sentence, sentence_hash = sentid(sentence)
    rows = ccgweb.db.get('''SELECT user_id
                            FROM correct
                            WHERE lang = %s
                            AND sentence_id = %s''', lang, sentence_hash)
    return set(user for (user,) in rows)


def annotator_sort_key(annotator):
    if annotator == 'auto':
        return (0, annotator)
    elif annotator == 'judge':
        return (2, annotator)
    else:
        return (1, annotator)


def get_comment(lang, sentence, user):
    sentence, sentence_hash = sentid(sentence)
    rows = ccgweb.db.get('''SELECT text
                            FROM comment
                            WHERE lang = %s
                            AND sentence_id = %s
                            AND user_id = %s''', lang, sentence_hash, user)
    if rows:
        return rows[0][0]
    else:
        return ''


def add_tok_bow(lang, sentence, offset, tag):
    sentence, sentence_hash = sentid(sentence)
    ccgweb.db.execute('''INSERT INTO bows_tok
                         (user_id, time, lang, sentence_id, offset, tag)
                         VALUES ('auto', NOW(), %s, %s, %s, %s)''',
                      lang, sentence_hash, offset, tag)
