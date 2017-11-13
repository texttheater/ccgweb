#!/usr/bin/env python3


import ccgweb


if __name__ == '__main__':
    sid2langhash = {}
    with ccgweb.db.conn as cursor:
        with open('data/tatoeba/sentences.csv') as f:
                for i, line in enumerate(f):
                    if i % 1000 == 0:
                        print('sentence', i)
                    sid, lang, text = line.split(maxsplit=2)
                    text_hash = ccgweb.sentence2hash(text)
                    text = text.encode('UTF-8')
                    cursor.execute('''INSERT INTO texts (lang, sentence_id, sentence)
                                      VALUES (%s, %s, %s)
                                      ON DUPLICATE KEY UPDATE sentence=%s''',
                                   (lang, text_hash, text, text))
                    sid2langhash[sid] = (lang, text_hash)
        with open('data/tatoeba/links.csv') as f:
            for i, line in enumerate(f):
                if i % 1000 == 0:
                    print('link', i)
                sid1, sid2 = line.split()
                try:
                    lang1, id1 = sid2langhash[sid1]
                    lang2, id2 = sid2langhash[sid2]
                except KeyError:
                    continue
                cursor.execute('''INSERT INTO text_links (lang1, id1, lang2, id2)
                                  VALUES (%s, %s, %s, %s)''',
                               (lang1, id2, lang2, id2))
