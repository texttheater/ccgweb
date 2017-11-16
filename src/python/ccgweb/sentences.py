import ccgweb
import ccgweb.users
import ccgweb.util
import falcon
import hashlib
import json
import os
import subprocess


class Sentence:

    def on_get(self, req, res, lang, sentence, user_id):
        assert lang in ['eng', 'deu', 'ita', 'nld']
        sentence_hash = sentence2hash(sentence)
        rows = ccgweb.db.get('''SELECT derxml
            FROM correct
            WHERE lang = %s
            AND sentence_id = %s
            AND user_id = %s''', lang, sentence_hash, user_id)
        if rows:
            derxml = rows[0][0]
        else:
            raw_path = get_raw_path(lang, sentence_hash)
            if not os.path.isfile(raw_path):
                ccgweb.util.makedirs(os.path.split(raw_path)[0])
                with open(raw_path, 'w', encoding='UTF-8') as f:
                    f.write(sentence)
            der_path = get_path(lang, sentence_hash, user_id, 'der.xml')
            subprocess.check_call(('./ext/produce/produce', der_path))
            with open(der_path, 'r') as f:
                derxml = f.read()
        res.content_type = 'application/json'
        res.body = json.dumps({'derxml': derxml, 'marked_correct': bool(rows)})

    def on_post(self, req, res, lang, sentence, user_id):
        assert lang in ['eng', 'deu', 'ita', 'nld']
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
                ccgweb.db.execute('''INSERT INTO correct
                    (lang, sentence_id, user_id, time, derxml)
                    VALUES (%s, %s, %s, NOW(), %s)
                    ON DUPLICATE KEY UPDATE
                    time = NOW(), derxml = %s''', lang, sentence_hash,
                    user, derxml, derxml)
            else:
                ccgweb.db.execute('''DELETE FROM correct
                    WHERE lang = %s
                    AND sentence_id = %s
                    AND user_id = %s''', lang, sentence_hash, user)
        else:
            res.status = falcon.HTTP_400
            return


def sentence2hash(sentence):
    return hashlib.sha1(sentence.encode('UTF-8')).hexdigest()
    

def get_raw_path(lang, sentence_hash):
    raw_dir = os.path.join('raw', lang, sentence_hash[:2])
    return os.path.join(raw_dir, '.'.join((sentence_hash, 'raw')))


def get_path(lang, sentence_hash, user, extension):
    out_dir = os.path.join('out', lang, sentence_hash[:2], sentence_hash)
    return os.path.join(out_dir, '.'.join((user, extension)))
