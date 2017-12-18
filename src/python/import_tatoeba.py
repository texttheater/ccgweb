#!/usr/bin/env python3


import ccgweb.sentences


if __name__ == '__main__':
    sid2langhash = {}
    with open('data/tatoeba/sentences.csv') as f:
        for i, line in enumerate(f):
            if i % 1000 == 0:
                print('sentence', i)
            sid, lang, sentence = line.split(maxsplit=2)
            if lang not in ('eng', 'deu', 'ita', 'nld'):
                continue # for now
            sentence, sentence_hash = ccgweb.sentences.sentid(sentence)
            ccgweb.db.execute('''INSERT INTO sentences (lang, sentence_id, sentence)
                                 VALUES (%s, %s, %s)
                                 ON DUPLICATE KEY UPDATE sentence=%s''',
                              lang, sentence_hash, sentence, sentence)
            sid2langhash[sid] = (lang, sentence_hash)
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
            ccgweb.db.execute('''INSERT INTO sentence_links (lang1, id1, lang2, id2)
                                 VALUES (%s, %s, %s, %s)
                                 ON DUPLICATE KEY UPDATE lang1 = %s''',
                              lang1, id1, lang2, id2, lang1)
