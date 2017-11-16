import ccgweb
import ccgweb.users
import falcon
import hashlib
import json
import os
import subprocess


class Sentence:

    def on_get(self, req, res, lang, sentence, user_id):
        assert lang in ['eng', 'deu', 'ita', 'nld']
        sentence_hash = sentence2hash(sentence)
        hash_group = sentence_hash[:2]
        raw_dir = os.path.join('raw', lang, hash_group)
        raw_file = os.path.join(raw_dir, sentence_hash + '.raw')
        out_dir = os.path.join('out', lang, hash_group, sentence_hash)
        der_file = os.path.join(out_dir, user_id + '.der.xml')
        if not os.path.isfile(raw_file):
            ccgweb.util.makedirs(raw_dir)
            with open(raw_file, 'w', encoding='UTF-8') as f:
                f.write(sentence)
        subprocess.check_call(('./ext/produce/produce', der_file))
        body = {}
        with open(der_file, 'r') as f:
            body['derxml'] = f.read()
        res.content_type = 'application/json'
        res.body = json.dumps(body)

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
                (user_id, time, sentence_id, offset_from, offset_to, tag)
                VALUES (%s, NOW(), %s, %s, %s, %s)''', user, sentence_hash,
                offset_from, offset_to, tag)
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
                (user_id, time, sentence_id, offset_from, offset_to)
                VALUES (%s, NOW(), %s, %s,%s)''', user, sentence_hash,
                offset_from, offset_to)
        else:
            res.status = falcon.HTTP_400
            return


def sentence2hash(sentence):
    return hashlib.sha1(sentence.encode('UTF-8')).hexdigest()
