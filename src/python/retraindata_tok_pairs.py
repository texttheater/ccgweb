#!/usr/bin/env python3


import ccgweb
import ccgweb.util
import sys


if __name__ == '__main__':
    try:
        _, lang, part = sys.argv
        if part not in ('traindevtest', 'train'):
            raise ValueError()
    except ValueError:
        print('USAGE: python3 retraindata_tok_pairs.py LANG traindevtest|train', file=sys.stderr)
        sys.exit(1)
    if part == 'train':
        cond = ' AND s1.assigned = 0 AND s2.assigned = 0'
    else:
        cond = ''
    rows = ccgweb.db.get('''SELECT l.id1, l.id2
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON l.lang1 = s1.lang
                            AND l.id1 = s1.sentence_id
                            INNER JOIN sentences AS s2
                            ON l.lang2 = s2.lang
                            AND l.id2 = s2.sentence_id
                            WHERE l.lang1 = 'eng'
                            AND l.lang2 = %s''' + cond, lang)
    with open('retrain/eng-{}-{}.eng.ids'.format(lang, part), 'w') as ids_eng, \
        open('retrain/eng-{}-{}.{}.ids'.format(lang, part, lang), 'w') as ids_for, \
        open('retrain/eng-{}-{}.eng.tok'.format(lang, part), 'w') as tok_eng, \
        open('retrain/eng-{}-{}.{}.tok'.format(lang, part, lang), 'w') as tok_for:
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
