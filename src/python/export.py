#!/usr/bin/env python3


import ccgweb
import ccgweb.util
import collections
import io
import os
import sys
import time
import tokenization


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


def filter_and_tokenize(rows, lang):
    """Filters and tokenizes sentence pairs.

    For each row r, r[0] must be the target sentence and r[1] must be the
    source sentence.

    Returns rows that can be tokenized as sentences, with elements
    trg_tokenized and src_tokenized added at the end of each row.
    """
    # Pre-tokenization filters:
    rows = tuple(r for r in rows if is_line(r[0]) and is_line(r[1]))
    rows = tuple(r for r in rows if '\xad' not in r[0] and '\xad' not in r[1])
    # Tokenization:
    trgtok = tokenization.tokenize((r[0] for r in rows), lang)
    srctok = tokenization.tokenize((r[1] for r in rows), 'eng')
    rows = tuple(r + (t, s) for r, t, s in zip(rows, trgtok, srctok))
    # Post-tokenization filters:
    rows = tuple(r for r in rows if r[-2] and r[-1])
    return rows


def export_proj1(lang, datadir):
    rows = ccgweb.db.get('''SELECT s1.sentence, s2.sentence
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            WHERE l.lang1 = %s
                            AND l.lang2 = "eng"''', lang)
    rows = filter_and_tokenize(rows, lang)
    src_raw_path = os.path.join(datadir, 'proj1.' + lang + '-eng.src.raw')
    trg_raw_path = os.path.join(datadir, 'proj1.' + lang + '-eng.trg.raw')
    src_tok_path = os.path.join(datadir, 'proj1.' + lang + '-eng.src.tok')
    trg_tok_path = os.path.join(datadir, 'proj1.' + lang + '-eng.trg.tok')
    with open(trg_raw_path, 'w') as trg_raw_file, \
         open(src_raw_path, 'w') as src_raw_file, \
         open(trg_tok_path, 'w') as trg_tok_file, \
         open(src_tok_path, 'w') as src_tok_file:
        for trg_sentence, src_sentence, trg_tokenized, src_tokenized in rows:
            trg_raw_file.write(trg_sentence)
            src_raw_file.write(src_sentence)
            trg_tok_file.write(trg_tokenized + '\n')
            src_tok_file.write(src_tokenized + '\n')


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
    rows = filter_and_tokenize(rows, lang)
    src_raw_path = os.path.join(datadir, 'train.' + lang + '-eng.src.raw')
    trg_raw_path = os.path.join(datadir, 'train.' + lang + '-eng.trg.raw')
    src_tok_path = os.path.join(datadir, 'train.' + lang + '-eng.src.tok')
    trg_tok_path = os.path.join(datadir, 'train.' + lang + '-eng.trg.tok')
    with open(trg_raw_path, 'w') as trg_raw_file, \
         open(src_raw_path, 'w') as src_raw_file, \
         open(trg_tok_path, 'w') as trg_tok_file, \
         open(src_tok_path, 'w') as src_tok_file:
        for trg_sentence, src_sentence, trg_tokenized, src_tokenized in rows:
            trg_raw_file.write(trg_sentence)
            src_raw_file.write(src_sentence)
            trg_tok_file.write(trg_tokenized + '\n')
            src_tok_file.write(src_tokenized + '\n')


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
                            AND c1.user_id = "judge"
                            AND c2.user_id = "judge"''', lang)
    # Check that each target sentence only appears once:
    ids = [r[0] for r in rows]
    assert len(ids) == len(set(ids))
    # Split into dev and test:
    rows = sorted(rows, key=lambda x: x[3]) # sort by English sentence ID
    sentences = {}
    sentences['dev'] = tuple((ts, ss, tp, sp) for ti, ts, tp, si, ss, sp in rows[:len(rows) // 2])
    sentences['test'] = tuple((ts, ss, tp, sp) for ti, ts, tp, si, ss, sp in rows[len(rows) // 2:])
    # Filter and tokenize:
    sentences['dev'] = filter_and_tokenize(sentences['dev'], lang)
    sentences['test'] = filter_and_tokenize(sentences['test'], lang)
    # Export:
    for portion, portion_sentences in sentences.items():
        trg_raw_path = os.path.join(datadir, portion + '.' + lang + '-eng.trg.raw')
        src_raw_path = os.path.join(datadir, portion + '.' + lang + '-eng.src.raw')
        trg_parse_path = os.path.join(datadir, portion + '.' + lang + '-eng.trg.gold.parse.tags')
        src_parse_path = os.path.join(datadir, portion + '.' + lang + '-eng.src.gold.parse.tags')
        trg_tok_path = os.path.join(datadir, portion + '.' + lang + '-eng.trg.tok')
        src_tok_path = os.path.join(datadir, portion + '.' + lang + '-eng.src.tok')
        with open(trg_raw_path, 'w') as trg_raw_file, \
             open(src_raw_path, 'w') as src_raw_file, \
             open(trg_parse_path, 'w') as trg_parse_file, \
             open(src_parse_path, 'w') as src_parse_file, \
             open(trg_tok_path, 'w') as trg_tok_file, \
             open(src_tok_path, 'w') as src_tok_file:
            for i, (trg_sentence, src_sentence, trg_parse, src_parse, trg_tokenized, src_tokenized) in enumerate(portion_sentences, start=1):
                preamble, trg_parse = trg_parse.split('\n\n', 1)
                assert is_block(trg_parse)
                assert trg_parse.startswith('ccg(1,\n')
                trg_parse = 'ccg(' + str(i) + trg_parse[5:]
                preamble, src_parse = src_parse.split('\n\n', 1)
                assert is_block(src_parse)
                assert src_parse.startswith('ccg(1,\n')
                src_parse = 'ccg(' + str(i) + src_parse[5:]
                trg_raw_file.write(trg_sentence)
                src_raw_file.write(src_sentence)
                trg_parse_file.write(trg_parse)
                src_parse_file.write(src_parse)
                trg_tok_file.write(trg_tokenized + '\n')
                src_tok_file.write(src_tokenized + '\n')


def export_user_devtest_trg(lang, user_name, datadir):
    rows = ccgweb.db.get('''SELECT s1.sentence_id, s1.sentence, s2.sentence_id, s2.sentence, cu1.parse
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            INNER JOIN correct AS cj1
                            ON (s1.lang, s1.sentence_id) = (cj1.lang, cj1.sentence_id)
                            INNER JOIN correct AS cj2
                            ON (s2.lang, s2.sentence_id) = (cj2.lang, cj2.sentence_id)
                            LEFT OUTER JOIN correct AS cu1
                            ON (s1.lang, s1.sentence_id) = (cu1.lang, cu1.sentence_id)
                            AND cu1.user_id = %s
                            WHERE l.lang1 = %s
                            AND l.lang2 = "eng"
                            AND s1.assigned = 1
                            AND s2.assigned = 1
                            AND cj1.user_id = "judge"
                            AND cj2.user_id = "judge"''', user_name, lang)
    # Check that each target sentence only appears once:
    ids = [r[0] for r in rows]
    assert len(ids) == len(set(ids))
    # Split into dev and test:
    rows = sorted(rows, key=lambda x: x[2]) # sort by English sentence ID
    sentences = {}
    sentences['dev'] = rows[:len(rows) // 2]
    sentences['test'] = rows[len(rows) // 2:]
    # Export:
    for portion, portion_sentences in sentences.items():
        trg_parse_path = os.path.join(datadir, portion + '.' + lang + '-eng.trg.' + user_name + '.parse.tags')
        with open(trg_parse_path, 'w') as trg_parse_file:
            for i, (trg_sentence_id, trg_sentence, _, _, trg_parse) in enumerate(portion_sentences, start=1):
                if trg_parse is None:
                    continue
                preamble, trg_parse = trg_parse.split('\n\n', 1)
                assert is_block(trg_parse)
                assert trg_parse.startswith('ccg(1,\n')
                trg_parse = 'ccg(' + str(i) + trg_parse[5:]
                trg_parse_file.write(trg_parse)


def export_user_devtest_src(lang, user_name, datadir):
    rows = ccgweb.db.get('''SELECT s1.sentence_id, s1.sentence, s2.sentence_id, s2.sentence, cu2.parse
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON (l.lang1, l.id1) = (s1.lang, s1.sentence_id)
                            INNER JOIN sentences AS s2
                            ON (l.lang2, l.id2) = (s2.lang, s2.sentence_id)
                            INNER JOIN correct AS cj1
                            ON (s1.lang, s1.sentence_id) = (cj1.lang, cj1.sentence_id)
                            INNER JOIN correct AS cj2
                            ON (s2.lang, s2.sentence_id) = (cj2.lang, cj2.sentence_id)
                            LEFT OUTER JOIN correct AS cu2
                            ON (s2.lang, s2.sentence_id) = (cu2.lang, cu2.sentence_id)
                            AND cu2.user_id = %s
                            WHERE l.lang1 = %s
                            AND l.lang2 = "eng"
                            AND s1.assigned = 1
                            AND s2.assigned = 1
                            AND cj1.user_id = "judge"
                            AND cj2.user_id = "judge"''', user_name, lang)
    # Check that each target sentence only appears once:
    ids = [r[0] for r in rows]
    assert len(ids) == len(set(ids))
    # Split into dev and test:
    rows = sorted(rows, key=lambda x: x[2]) # sort by English sentence ID
    sentences = {}
    sentences['dev'] = rows[:len(rows) // 2]
    sentences['test'] = rows[len(rows) // 2:]
    # Export:
    for portion, portion_sentences in sentences.items():
        src_parse_path = os.path.join(datadir, portion + '.' + lang + '-eng.src.' + user_name + '.parse.tags')
        with open(src_parse_path, 'w') as src_parse_file:
            for i, (_, _, src_sentence_id, src_sentence, src_parse) in enumerate(portion_sentences, start=1):
                if src_parse is None:
                    continue
                preamble, src_parse = src_parse.split('\n\n', 1)
                assert is_block(src_parse)
                assert src_parse.startswith('ccg(1,\n')
                src_parse = 'ccg(' + str(i) + src_parse[5:]
                src_parse_file.write(src_parse)


if __name__ == '__main__':
    try:
        _, datadir = sys.argv
    except ValueError:
        print('USAGE: python3 export.py DATADIR', file=sys.stderr)
        sys.exit(1)
    for lang in ('deu', 'ita', 'nld'):
        print(lang)
        ccgweb.util.makedirs(datadir)
        for user_name in reversed(ccgweb.config['human_annotators']):
            print(user_name)
            export_user_devtest_trg(lang, user_name, datadir)
            export_user_devtest_src(lang, user_name, datadir)
        export_devtest(lang, datadir)
    for lang in ccgweb.supported_languages:
        print(lang)
        export_proj1(lang, datadir)
        export_train(lang, datadir)
