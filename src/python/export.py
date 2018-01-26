#!/usr/bin/env python3


import ccgweb
import ccgweb.util
import collections
import os
import sys


def export_train(datadir):
    rows = ccgweb.db.get('''SELECT l.lang1, l.id1, s1.sentence, l.id2, s2.sentence
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            WHERE l.lang2 = "eng"
                            AND s1.assigned = 0''')
    for lang1, id1, sentence1, id2, sentence2 in rows:
        dirpath = os.path.join(datadir, 'train', lang1 + '-eng', id1[:2], id1 + '-' + id2)
        srcpath = os.path.join(dirpath, 'src.raw')
        trgpath = os.path.join(dirpath, 'trg.raw')
        ccgweb.util.makedirs(dirpath)
        with open(srcpath, 'w') as f:
            f.write(sentence2)
        with open(trgpath, 'w') as f:
            f.write(sentence1)

def export_devtest(datadir):
    for lang in ('eng', 'deu', 'ita', 'nld'):
        rows = ccgweb.db.get('''SELECT s.sentence_id, s.sentence, c.derxml
                                FROM sentences AS s
                                INNER JOIN correct AS c
                                ON (s.lang, s.sentence_id) = (c.lang, c.sentence_id)
                                WHERE s.lang = %s
                                AND s.assigned = 1
                                AND c.user_id = "judge"''', lang)
        # Split into dev and test:
        rows = sorted(rows)
        sentences = {}
        sentences['dev'] = rows[:len(rows) // 2]
        sentences['test'] = rows[len(rows) // 2:]
        # Export:
        for portion, portion_sentences in sentences.items():
            for sentence_id, raw, derxml in portion_sentences:
                dirpath = os.path.join(datadir, portion, lang, sentence_id[:2])
                rawpath = os.path.join(dirpath, sentence_id + '.raw')
                derxmlpath = os.path.join(dirpath, sentence_id + '.der.xml')
                ccgweb.util.makedirs(dirpath)
                with open(rawpath, 'w') as f:
                    f.write(raw)
                with open(derxmlpath, 'w') as f:
                    f.write(derxml)


if __name__ == '__main__':
    try:
        _, datadir = sys.argv
    except ValueError:
        print('USAGE: python3 export.py DATADIR', file=sys.stderr)
        sys.exit(1)
    #export_train(datadir)
    export_devtest(datadir)
