#!/usr/bin/env python3


import ccgweb
import ccgweb.sentences
import sys


if __name__ == '__main__':
    try:
        _, lang, sentence_id = sys.argv
    except ValueError:
        print('USAGE: python3 raw.py LANG SENTENCE_ID', file=sys.stderr)
        sys.exit(1)
    rows = ccgweb.db.get('''SELECT sentence
                            FROM sentences
                            WHERE lang = %s
                            AND sentence_id = %s''', lang, sentence_id)
    print(rows[0][0], end='')
