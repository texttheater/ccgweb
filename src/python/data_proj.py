#!/usr/bin/env python3


"""Lists the targets for derivation projection.
"""


import ccgweb
import os
import sys


if __name__ == '__main__':
    try:
        _, lang, part = sys.argv
        if part not in ('traindevtest', 'train'):
            raise ValueError()
    except ValueError:
        print('USAGE: python3 data_proj.py LANG traindevtest|train', file=sys.stderr)
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
    for id1, id2 in rows:
        print(os.path.join('out', lang, id2[:2], id2, 'proj', id1, 'proj-' + part + '.parse.tags'))
