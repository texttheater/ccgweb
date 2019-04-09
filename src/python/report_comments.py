#!/usr/bin/env python3


import ccgweb


def level(comment):
    level = 0
    for line in comment.splitlines():
        if line.startswith('no disagreements'):
            pass
        elif line.startswith('guideline not observed'):
            level = max(level, 1)
        elif line.startswith('oversight'):
            level = max(level, 2)
        elif line.startswith('missing guideline'):
            level = max(level, 3)
        else:
            raise RuntimeError('could not parse comment line: ' + line)
    return level


if __name__ == '__main__':
    rows = ccgweb.db.get('''SELECT c.lang, c.sentence_id, c.text, s.sentence
                            FROM comment AS c
                            INNER JOIN sentences AS s
                            ON (c.lang, c.sentence_id) = (s.lang, s.sentence_id)''')
    for lang, sentence_id, comment, sentence in rows:
        print(lang, sentence_id, level(comment), sentence, end='')

