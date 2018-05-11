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
    # Step 1: collect relevant non-English sentences
    ftid_pair_dict = {}
    with tarfile.open(sentences_path) as tar:
        with tar.extractfile('sentences.csv') as f:
            for line in f:
                line = line.decode('UTF-8')
                ftid, lang, sent = line.split(maxsplit=2)
                if not lang in ('deu', 'nld', 'ita'):
                    continue
                fpair = ccgweb.sentences.sentid(sent)
                ftid_pair_dict[ftid] = (lang, fpair)
    # Step 2: collect the IDs of linked English sentences
    etid_ftids_dict = collections.defaultdict(set)
    with tarfile.open(links_path) as tar:
        with tar.extractfile('links.csv') as f:
            for line in f:
                line = line.decode('UTF-8')
                ftid, etid= line.split()
                if not ftid in ftid_pair_dict:
                    continue
                etid_ftids_dict[etid].add(ftid)
    # Step 3: collect the linked English sentences and insert
    with tarfile.open(sentences_path) as tar:
        with tar.extractfile('sentences.csv') as f:
            for i, line in enumerate(f):
                if i % 1000 == 0:
                    print(i)
                line = line.decode('UTF-8')
                etid, lang, esent = line.split(maxsplit=2)
                if lang != 'eng':
                    continue
                if etid not in etid_ftids_dict:
                    continue
                epair = ccgweb.sentences.sentid(esent)
                ccgweb.db.execute('''INSERT INTO sentences
                                     (lang, sentence_id, sentence)
                                     VALUES ('eng', %s, %s)
                                     ON DUPLICATE KEY UPDATE lang = 'eng' ''',
                                  epair[1], epair[0])
                ftids = etid_ftids_dict[etid]
                for ftid in ftids:
                    lang, fpair = ftid_pair_dict[ftid]
                    ccgweb.db.execute('''INSERT INTO sentences
                                         (lang, sentence_id, sentence)
                                         VALUES (%s, %s, %s)
                                         ON DUPLICATE KEY UPDATE lang = %s''',
                                         lang, fpair[1], fpair[0], lang)
                    ccgweb.db.execute('''INSERT INTO sentence_links
                                         (lang1, id1, lang2, id2)
                                         VALUES ('eng', %s, %s, %s)
                                         ON DUPLICATE KEY UPDATE lang1 = 'eng' ''',
                                      epair[1], lang, fpair[1])
                    ccgweb.db.execute('''INSERT INTO sentence_links
                                         (lang1, id1, lang2, id2)
                                         VALUES (%s, %s, %s, %s)
                                         ON DUPLICATE KEY UPDATE lang2 = 'eng' ''',
                                      lang, fpair[1], 'eng', epair[1])
