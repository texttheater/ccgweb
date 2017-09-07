import hashlib
import json
import MySQLdb
import os
import ccgweb.util
import subprocess


class DB:

    def __init__(self, connection_object):
        self.cursor = connection_object.cursor()

    def get(self, sql, *args):
        self.cursor.execute(sql, args)
        return self.cursor.fetchall()

    def execute(self, sql, *args):
        self.cursor.execute(sql, args)


class Sentence:

    def on_get(self, req, res, sentence):
        sentence_hash = hashlib.sha1(sentence.encode('UTF-8')).hexdigest()
        hash_group = sentence_hash[:2]
        raw_dir = os.path.join('raw', hash_group)
        raw_file = os.path.join(raw_dir, sentence_hash + '.raw')
        out_dir = os.path.join('out', hash_group, sentence_hash)
        der_file = os.path.join(out_dir, 'auto.der.xml')
        if not os.path.isfile(raw_file):
            ccgweb.util.makedirs(raw_dir)
            with open(raw_file, 'w', encoding='UTF-8') as f:
                f.write(sentence)
        subprocess.check_call(('./ext/produce/produce', der_file))
        res.content_type = 'application/xml'
        with open(der_file, 'rb') as f:
            res.data = f.read()


with open('config.json') as f:
    config = json.load(f)


db = DB(MySQLdb.connect(config['db_host'], config['db_user'],
                        config['db_pass'], config['db_name']))
