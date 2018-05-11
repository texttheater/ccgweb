#!/usr/bin/env python3


import ccgweb
import ccgweb.sentences
import collections
import sys
import tarfile




if __name__ == '__main__':
    try:
        _, sentences_path, links_path = sys.argv
    except ValueError:
        print('USAGE: python3 sentences.tar.bz2 links.tar.bz2',
              file=sys.stderr)
        sys.exit(1)
    # Step 1: map Tatoeba IDs to (lang, sentence_id, sentence) triples
    tid_sentinfo_dict = {}
    with tarfile.open(sentences_path) as tar:
        with tar.extractfile('sentences.csv') as f:
            for i, line in enumerate(f):
                if i % 1000 == 0:
                    print('{} sentences read'.format(i))
                line = line.decode('UTF-8')
                tid, lang, sentence = line.split(maxsplit=2)
                if lang not in ('eng', 'deu', 'nld', 'ita'):
                    continue
                sentence, sentence_id = ccgweb.sentences.sentid(sentence)
                tid_sentinfo_dict[tid] = (lang, sentence_id, sentence)
    print(len(tid_sentinfo_dict), 'sentences')
    # Step 2: collect links
    link_dict = collections.defaultdict(set)
    i = 0
    with tarfile.open(links_path) as tar:
        with tar.extractfile('links.csv') as f:
            for i, line in enumerate(f):
                if i % 1000 == 0:
                    print('{} links read'.format(i))
                line = line.decode('UTF-8')
                tid1, tid2 = line.split()
                if not tid1 in tid_sentinfo_dict:
                    continue
                if not tid2 in tid_sentinfo_dict:
                    continue
                lang1, id1, _ = tid_sentinfo_dict[tid1]
                lang2, id2, _ = tid_sentinfo_dict[tid2]
                link_dict[(lang1, id1)].add((lang2, id2))
                i += 1
    print(i, 'links')
    # Step 3: filter out unlinked sentences
    def is_linked(triple):
        lang, sentence_id, sentence = triple
        if lang == 'eng':
            return (lang, sentence_id) in link_dict
        return any(l == 'eng' for l, sid in link_dict[(lang, sentence_id)])
    sentences = [s for s in tid_sentinfo_dict.values() if is_linked(s)]
    # Step 4: insert sentences and links
    ccgweb.db.connect()
    with ccgweb.db.conn as cursor:
        # Step 4.1: insert sentences
        sentence_count = len(sentences)
        for i, (lang, sentence_id, sentence) in enumerate(sentences):
            if i % 1000 == 0:
                print('{}/{} sentences inserted'.format(i, sentence_count))
            cursor.execute('''INSERT INTO sentences
                              (lang, sentence_id, sentence)
                              VALUES (%s, %s, %s)
                              ON DUPLICATE KEY UPDATE lang = %s''',
                           (lang, sentence_id, sentence, lang))
        # Step 4.2: insert links
        link_count = sum(len(l) for l in link_dict.values())
        i = 0
        for lang1, id1 in link_dict:
            for lang2, id2 in link_dict[(lang1, id1)]:
                if i % 1000 == 0:
                    print('{}/{} links inserted'.format(i, link_count))
                i += 1
                cursor.execute('''INSERT INTO sentence_links
                                  (lang1, id1, lang2, id2)
                                  VALUES (%s, %s, %s, %s)
                                  ON DUPLICATE KEY UPDATE lang1 = %s''',
                               (lang1, id1, lang2, id2, lang1))
