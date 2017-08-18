import hashlib
import os
import ccgweb.util
import subprocess


class Sentence:

    def on_get(self, req, res, sentence):
        # TODO refuse sentences not in our database
        sentence_hash = hashlib.sha256(sentence.encode('UTF-8')).hexdigest()
        dirname = os.path.join('out', sentence_hash[:2])
        rawname = os.path.join(dirname, sentence_hash + '.raw')
        if not os.path.isfile(rawname):
            ccgweb.util.makedirs(dirname)
            with open(rawname, 'w', encoding='UTF-8') as f:
                f.write(sentence)
        dername = os.path.join(dirname, sentence_hash + '.der.xml')
        subprocess.check_call(('./ext/produce/produce', dername))
        res.content_type = 'application/xml'
        with open(dername, 'rb') as f:
            res.data = f.read()
