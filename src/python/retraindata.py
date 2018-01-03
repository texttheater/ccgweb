#!/usr/bin/env python3


import ccgweb


if __name__ == '__main__':
    rows = ccgweb.db.get('''SELECT id1, lang2, id2
                            FROM sentence_links
                            WHERE lang1 = 'eng'
                            AND lang2 IN ('deu', 'ita', 'nld')''')
    pairs = set()
    for id1, lang2, id2 in rows:
        pairs.add(('eng', id1))
        pairs.add((lang2, id2))
    for lang, sid in pairs:
        print('out/{}/{}/{}/auto.tok.off'.format(lang, sid[:2], sid))
