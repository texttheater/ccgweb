#!/usr/bin/env python3


import ccgweb
import ccgweb.util
import sys


if __name__ == '__main__':
    try:
        _, lang = sys.argv
    except ValueError:
        print('USAGE: python3 retraindata_tok_pairs.py LANG', file=sys.stderr)
        sys.exit(1)
    rows = ccgweb.db.get('''SELECT id1, id2
                            FROM sentence_links
                            WHERE lang1 = 'eng'
                            AND lang2 = %s''', lang)
    with open('retrain/eng-{}.eng.ids'.format(lang), 'w') as ids_eng, \
        open('retrain/eng-{}.{}.ids'.format(lang, lang), 'w') as ids_for, \
        open('retrain/eng-{}.eng.tok'.format(lang), 'w') as tok_eng, \
        open('retrain/eng-{}.{}.tok'.format(lang, lang), 'w') as tok_for:
        for id1, id2 in rows:
            tokfile_eng = 'out/eng/{}/{}/auto.tok'.format(id1[:2], id1)
            tokfile_for = 'out/{}/{}/{}/auto.tok'.format(lang, id2[:2], id2)
            lines_eng = ccgweb.util.slurp(tokfile_eng).splitlines()
            lines_for = ccgweb.util.slurp(tokfile_for).splitlines()
            if len(lines_eng) != 1 or len(lines_for) != 1:
                continue
            print(id1, file=ids_eng)
            print(id2, file=ids_for)
            print(lines_eng[0], file=tok_eng)
            print(lines_for[0], file=tok_for)
