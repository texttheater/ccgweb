#!/usr/bin/env python3


import ccgweb
import ccgweb.util
import collections
import io
import os
import sys
import time


def is_line(string):
    return string.endswith('\n') and '\n' not in string[:-1]


def is_block(string):
    return string.endswith('\n\n') and '\n\n' not in string[:-1]


def is_single_sentence(tok):
    lines = tok.splitlines()
    fieldss = [line.split() for line in lines]
    tokids = [fields[2] for fields in fieldss]
    sentids = [tokid[:2] for tokid in tokids]
    return len(set(sentids)) == 1


def export_proj1(lang, datadir):
    rows = ccgweb.db.get('''SELECT s1.sentence, s2.sentence
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            WHERE lang1 = %s
                            AND l.lang2 = "eng"''', lang)
    src_raw_path = os.path.join(datadir, 'proj1.' + lang + '-eng.src.raw')
    trg_raw_path = os.path.join(datadir, 'proj1.' + lang + '-eng.trg.raw')
    with open(src_raw_path, 'w') as src_raw_file, \
            open(trg_raw_path, 'w') as trg_raw_file:
        for trg_sentence, src_sentence in rows:
            if not is_line(trg_sentence):
                continue
            if not is_line(src_sentence):
                continue
            src_raw_file.write(src_sentence)
            trg_raw_file.write(trg_sentence)


def export_train(lang, datadir):
    rows = ccgweb.db.get('''SELECT s1.sentence, s2.sentence
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            WHERE lang1 = %s
                            AND l.lang2 = "eng"
                            AND s1.assigned = 0''', lang)
    src_raw_path = os.path.join(datadir, 'train.' + lang + '-eng.src.raw')
    trg_raw_path = os.path.join(datadir, 'train.' + lang + '-eng.trg.raw')
    with open(src_raw_path, 'w') as src_raw_file, \
            open(trg_raw_path, 'w') as trg_raw_file:
        for trg_sentence, src_sentence in rows:
            if not is_line(trg_sentence):
                continue
            if not is_line(src_sentence):
                continue
            src_raw_file.write(src_sentence)
            trg_raw_file.write(trg_sentence)


def export_devtest(lang, datafile):
    rows = ccgweb.db.get('''SELECT s.sentence_id, s.sentence, c.parse
                            FROM sentences AS s
                            INNER JOIN correct AS c
                            ON (s.lang, s.sentence_id) = (c.lang, c.sentence_id)
                            WHERE s.lang = %s
                            AND s.assigned = 1
                            AND c.user_id = "kilian"''', lang) # XXX use judge
    # Split into dev and test:
    rows = sorted(rows)
    sentences = {}
    sentences['dev'] = rows[:len(rows) // 2]
    sentences['test'] = rows[len(rows) // 2:]
    # Export:
    for portion, portion_sentences in sentences.items():
        raw_path = os.path.join(datadir, portion + '.' + lang + '.raw')
        tok_path = os.path.join(datadir, portion + '.' + lang + '.tok.off')
        parse_path = os.path.join(datadir, portion + '.' + lang + '.parse.tags')
        with open(raw_path, 'w') as raw_file, open(tok_path, 'w') as tok_file, \
                open(parse_path, 'w') as parse_file:
            for sentence_id, raw, parse in portion_sentences:
                if not is_line(raw):
                    continue
                tokpath_from = os.path.join('out', lang, sentence_id[:2], sentence_id, 'auto.tok.off')
                with open(tokpath_from) as f:
                    tok = f.read()
                assert is_single_sentence(tok)
                tok = tok + '\n'
                assert is_block(tok)
                preamble, parse = parse.split('\n\n', 1)
                assert is_block(parse)
                raw_file.write(raw)
                tok_file.write(tok)
                parse_file.write(parse)


if __name__ == '__main__':
    try:
        _, datadir = sys.argv
    except ValueError:
        print('USAGE: python3 export.py DATADIR', file=sys.stderr)
        sys.exit(1)
    for lang in ('deu', 'ita', 'nld'):
        export_proj1(lang, datadir)
        export_train(lang, datadir)
        export_devtest(lang, datadir)
