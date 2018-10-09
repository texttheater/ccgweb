#!/usr/bin/env python3


"""Imports projections, output of cross-lingually trained EasyCCG into CCGWeb.
"""


import ccgweb
import ccgweb.sentences
import ccgweb.util
import derxml
import pathlib
import re
import subprocess
import sys
import tempfile


if __name__ == '__main__':
    # Parse args:
    try:
        _, xlci_dir = sys.argv
    except ValueError:
        print('USAGE: python3 import_xlci.py XLCIDIR', file=sys.stderr)
        sys.exit(1)
    # Delete old data:
    ccgweb.db.execute('''DELETE FROM correct
                         WHERE user_id in ("xl.1.feats", "xl.2.feats")''')
    # Import:
    xlci_path = pathlib.Path(xlci_dir)
    data_path = xlci_path / 'data'
    out_path = xlci_path / 'out'
    for lang in ('deu', 'ita', 'nld'):
        for portion in ('dev', 'test'):
            raw_path = data_path / '{}.{}-eng.trg.raw'.format(portion, lang)
            sentence_ids = []
            with open(raw_path) as f:
                for line in f:
                    sentence, sentence_id = ccgweb.sentences.sentid(line)
                    sentence_ids.append(sentence_id)
            for user_id in ('xl.1.feats', 'xl.2.feats'):
                parse_path = out_path / '{}.{}-eng.trg.{}.parse.tags'.format(portion, lang, user_id)
                try:
                    with open(parse_path) as f:
                        blocks = list(ccgweb.util.blocks(f))
                except FileNotFoundError:
                    continue
                parses = blocks[1:]
                assert len(parses) == len(sentence_ids)
                for sentence_id, parse in zip(sentence_ids, parses):
                    with tempfile.NamedTemporaryFile() as f:
                        f.write(parse.encode('UTF-8'))
                        f.flush()
                        derxml = subprocess.check_output(('swipl', '-l', 'src/prolog/parse2xml.pl', '-g', 'main', f.name))
                    ccgweb.db.execute('''INSERT INTO correct
                                         (lang, sentence_id, user_id, time, derxml, parse)
                                         VALUES (%s, %s, %s, NOW(), %s, %s)''',
                                      lang, sentence_id, user_id, derxml, parse)
