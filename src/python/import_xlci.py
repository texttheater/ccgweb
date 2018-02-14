#!/usr/bin/env python3


"""Imports output of cross-lingually trained EasyCCG into CCGWeb.
"""


import ccgweb
import pathlib
import sys


if __name__ == '__main__':
    try:
        _, xlci_dir = sys.argv
    except ValueError:
        print('USAGE: python3 import_xlci.py XLCIDIR', file=sys.stderr)
        sys.exit(1)
    ccgweb.db.execute('''DELETE FROM correct
                         WHERE user_id = "xl" ''')
    dev_path = pathlib.Path(xlci_dir) / 'out' / 'dev'
    for lang_path in dev_path.iterdir():
        for prefix_path in lang_path.iterdir():
            for sid_path in prefix_path.iterdir():
                derxml_path = sid_path / 'xl.der.xml.incomplete'
                parse_path = sid_path / 'xl.parse.tags'
                with open(derxml_path) as f:
                    derxml = f.read()
                with open(parse_path) as f:
                    parse = f.read()
                ccgweb.db.execute('''INSERT INTO correct
                                     (lang, sentence_id, user_id, time, derxml, parse)
                                     VALUES (%s, %s, 'xl', NOW(), %s, %s)''',
                                  lang_path.name, sid_path.name, derxml, parse)
