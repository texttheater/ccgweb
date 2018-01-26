#!/usr/bin/env python3


import ccgweb
import ccgweb.util
import collections
import io
import os
import sys
import tarfile
import time


def add_text_file_to_tar(path, text, tar, encoding='UTF-8'):
    binary = text.encode(encoding)
    info = tarfile.TarInfo(path)
    info.size = len(binary)
    info.mtime = time.time()
    with io.BytesIO(binary) as f:
        tar.addfile(info, f)


def export_train(datafile):
    rows = ccgweb.db.get('''SELECT l.lang1, l.id1, s1.sentence, l.id2, s2.sentence
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            WHERE l.lang2 = "eng"
                            AND s1.assigned = 0''')
    for lang1, id1, sentence1, id2, sentence2 in rows:
        dirpath = os.path.join('data', 'train', lang1 + '-eng', id1[:2], id1 + '-' + id2)
        srcpath = os.path.join(dirpath, 'src.raw')
        trgpath = os.path.join(dirpath, 'trg.raw')
        ccgweb.util.makedirs(dirpath)
        add_text_file_to_tar(srcpath, sentence2, datafile)
        add_text_file_to_tar(trgpath, sentence1, datafile)

def export_devtest(datafile):
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
                dirpath = os.path.join('data', portion, lang, sentence_id[:2])
                rawpath = os.path.join(dirpath, sentence_id + '.raw')
                derxmlpath = os.path.join(dirpath, sentence_id + '.der.xml')
                ccgweb.util.makedirs(dirpath)
                add_text_file_to_tar(rawpath, raw, datafile)
                add_text_file_to_tar(derxmlpath, derxml, datafile)


if __name__ == '__main__':
    try:
        _, datafile = sys.argv
    except ValueError:
        print('USAGE: python3 export.py DATAFILE.tar.gz', file=sys.stderr)
        sys.exit(1)
    os.unlink(datafile)
    with tarfile.open(datafile, 'w:gz') as f:
        export_train(f)
        export_devtest(f)
