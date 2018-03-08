#!/usr/bin/env python3


"""Imports output of cross-lingually trained EasyCCG into CCGWeb.
"""


import ccgweb
import ccgweb.util
import pathlib
import sys


if __name__ == '__main__':
    try:
        _, xlci_dir = sys.argv
    except ValueError:
        print('USAGE: python3 import_xlci.py XLCIDIR', file=sys.stderr)
        sys.exit(1)
    ccgweb.db.execute('''DELETE FROM correct
                         WHERE user_id in ("proj", "xl")''')
    dev_path = pathlib.Path(xlci_dir, 'out', 'dev')
    for lang_path in dev_path.iterdir():
        for prefix_path in lang_path.iterdir():
            for sid_path in prefix_path.iterdir():
                derxml_path = sid_path / 'xl.der.xml.incomplete'
                parse_path = sid_path / 'xl.parse.tags'
                derxml = ccgweb.util.slurp(derxml_path)
                parse = ccgweb.util.slurp(parse_path)
                ccgweb.db.execute('''INSERT INTO correct
                                     (lang, sentence_id, user_id, time, derxml, parse)
                                     VALUES (%s, %s, 'xl', NOW(), %s, %s)''',
                                  lang_path.name, sid_path.name, derxml, parse)
    assigned = ccgweb.db.get('''SELECT lang, sentence_id
                                FROM sentences
                                WHERE assigned = 1
                                AND lang <> "eng"''')
    for lang, sentence_id in assigned:
        prefix_path = pathlib.Path(xlci_dir, 'out', 'proj1', lang + '-eng', sentence_id[:2])
        sent_paths = [p for p in prefix_path.iterdir() if p.name.startswith(sentence_id)]
        for sent_path in sent_paths:
            derxml_path = sent_path / 'trg.der.xml.incomplete'
            parse_path = sent_path / 'trg.parse.tags'
            try:
                parse = ccgweb.util.slurp(parse_path)
            except FileNotFoundError:
                continue
            if not parse:
                continue
            derxml = ccgweb.util.slurp(derxml_path)
            ccgweb.db.execute('''INSERT INTO correct
                                 (lang, sentence_id, user_id, time, derxml, parse)
                                 VALUES (%s, %s, 'proj', NOW(), %s, %s)
                                 ON DUPLICATE KEY UPDATE time = NOW(), derxml = %s, parse = %s''',
                              lang, sentence_id, derxml, parse, derxml, parse)
