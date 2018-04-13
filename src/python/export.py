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
                            WHERE l.lang1 = %s
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
            if '\xad' in trg_sentence:
                continue
            if '\xad' in src_sentence:
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
                            WHERE l.lang1 = %s
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
            if '\xad' in trg_sentence:
                continue
            if '\xad' in src_sentence:
                continue
            src_raw_file.write(src_sentence)
            trg_raw_file.write(trg_sentence)


def export_devtest(lang, datadir):
    rows = ccgweb.db.get('''SELECT s1.sentence_id, s1.sentence, c1.parse, s2.sentence_id, s2.sentence, c2.parse
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            INNER JOIN correct AS c1
                            ON (s1.lang, s1.sentence_id) = (c1.lang, c1.sentence_id)
                            INNER JOIN correct AS c2
                            ON (s2.lang, s2.sentence_id) = (c2.lang, c2.sentence_id)
                            WHERE l.lang1 = %s
                            AND l.lang2 = "eng"
                            AND s1.assigned = 1
                            AND s2.assigned = 1
                            AND c1.user_id = "kilian"
                            AND c2.user_id = "kilian"''', lang) # XXX use judge
    # Check that each target sentence only appears once:
    ids = [r[0] for r in rows]
    assert len(ids) == len(set(ids))
    # Split into dev and test:
    rows = sorted(rows)
    sentences = {}
    sentences['dev'] = rows[:len(rows) // 2]
    sentences['test'] = rows[len(rows) // 2:]
    # Export:
    for portion, portion_sentences in sentences.items():
        trg_raw_path = os.path.join(datadir, portion + '.' + lang + '-eng.trg.raw')
        src_raw_path = os.path.join(datadir, portion + '.' + lang + '-eng.src.raw')
        trg_parse_path = os.path.join(datadir, portion + '.' + lang + '-eng.trg.gold.parse.tags')
        src_parse_path = os.path.join(datadir, portion + '.' + lang + '-eng.src.gold.parse.tags')
        with open(trg_raw_path, 'w') as trg_raw_file, \
            open(src_raw_path, 'w') as src_raw_file, \
            open(trg_parse_path, 'w') as trg_parse_file, \
            open(src_parse_path, 'w') as src_parse_file:
            for trg_sentence_id, trg_sentence, trg_parse, src_sentence_id, src_sentence, src_parse in portion_sentences:
                if not is_line(trg_sentence):
                    continue
                if not is_line(src_sentence):
                    continue
                if '\xad' in trg_sentence:
                    continue
                if '\xad' in src_sentence:
                    continue
                preamble, trg_parse = trg_parse.split('\n\n', 1)
                assert is_block(trg_parse)
                trg_raw_file.write(trg_sentence)
                src_raw_file.write(src_sentence)
                trg_parse_file.write(trg_parse)
                src_parse_file.write(src_parse)


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
