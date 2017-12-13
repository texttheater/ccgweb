#!/usr/bin/env python3


"""
Imports the intersection of PMB and Tatoeba into CCGWeb.
"""


import ccgweb
import ccgweb.sentences
import ccgweb.util
import glob
import os
import sys


langmap = {'en': 'eng', 'de': 'deu', 'it': 'ita', 'nl': 'nld'}


if __name__ == '__main__':
    try:
        _, rawdir = sys.argv
    except ValueError:
        print('USAGE: python3 import_pmb.py PMBRAWDIR', file=sys.stderr)
        sys.exit(1)
    for part in range(100):
        part = format(part, '02d')
        for doc_id in range(10000):
            doc_id = format(doc_id, '04d')
            docdir = os.path.join(rawdir, 'p' + part, 'd' + doc_id)
            metpath = os.path.join(docdir, 'en.met')
            if not os.path.isfile(metpath):
                continue
            print(metpath)
            met = ccgweb.util.slurp(metpath, encodings=('UTF-8', 'Windows-1252'))
            if not 'subcorpus: Tatoeba' in met:
                continue
            lang2sent = {}
            for lang in langmap:
                rawpath = os.path.join(docdir, lang + '.raw')
                if os.path.isfile(rawpath):
                    sent = ccgweb.util.slurp(rawpath)
                    sent, sid = ccgweb.sentences.sentid(sent)
                    lang2sent[lang] = (sent, sid)
            for lang, sent in lang2sent.items():
                sent, sid = sent
                ccgweb.db.execute('''INSERT INTO sentences (lang, sentence_id, sentence)
                                     VALUES (%s, %s, %s)
                                     ON DUPLICATE KEY UPDATE lang = %s''',
                                  langmap[lang], sid, sent, langmap[lang])
                ccgweb.db.execute('''INSERT INTO sentence_pmbids (lang, sentence_id, pmb_part, pmb_doc_id)
                                     VALUES (%s, %s, %s, %s)
                                     ON DUPLICATE KEY UPDATE lang = %s''', langmap[lang], sid, part, doc_id, lang)
                for olang, osent in lang2sent.items():
                    if olang == lang:
                        continue
                    osent, osid = osent
                    ccgweb.db.execute('''INSERT INTO sentence_links (lang1, id1, lang2, id2)
                                         VALUES (%s, %s, %s, %s)
                                         ON DUPLICATE KEY UPDATE lang1 = %s''',
                                      langmap[lang], sid, langmap[olang], osid, langmap[lang])
