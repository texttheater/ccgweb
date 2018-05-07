#!/usr/bin/env python3


import ccgweb
import datetime


if __name__ == '__main__':
    rows = ccgweb.db.get('''SELECT s.lang, s.sentence, c.text, c.time
                            FROM sentences AS s
                            INNER JOIN comment AS c
                            ON (s.lang, s.sentence_id) = (c.lang, c.sentence_id)''')
    for lang, sentence, comment, time in rows:
        comment_lines = comment.splitlines()
        comment_lines = [l for l in comment_lines if l.startswith('missing guideline ')]
        if comment_lines and time > datetime.datetime(2018, 5, 7, 0, 0, 0):
            print('[{}] {}'.format(lang, sentence), end='')
            for line in comment_lines:
                print(line.rstrip())
            print()
