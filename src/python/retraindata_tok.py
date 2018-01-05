#!/usr/bin/env python3


import ccgweb
import sys


if __name__ == '__main__':
    try:
        _, lang = sys.argv
    except ValueError:
        print('USAGE: python3 retraindata_tok.py LANG', file=sys.stderr)
        sys.exit(1)
    rows = ccgweb.db.get('''SELECT id1, id2
                            FROM sentence_links
                            WHERE lang1 = 'eng'
                            AND lang2 = %s''', lang)
    pairs = set()
    for id1, id2 in rows:
        pairs.add(('eng', id1))
        pairs.add((lang, id2))
    for l, sid in pairs:
        print('out/{}/{}/{}/auto.tok'.format(l, sid[:2], sid))
