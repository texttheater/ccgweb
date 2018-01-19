#!/usr/bin/env python3


import sys


if __name__ == '__main__':
    try:
        _, gold, decoded = sys.argv
    except ValueError:
        print('USAGE: python3 eval_stagged.py GOLD DECODED', file=sys.stderr)
        sys.exit(1)
    with open(gold) as f:
        gold_lines = list(f)
    with open(decoded) as f:
        decoded_lines = list(f)
    assert len(gold_lines) == len(decoded_lines)
    cats_total = 0
    cats_correct = 0
    for gold_line, decoded_line in zip(gold_lines, decoded_lines):
        gold_tokens = gold_line.rstrip().split(' ')
        decoded_tokens = decoded_line.rstrip().split(' ')
        gold_forms, _, gold_cats = zip(*(t.rsplit('|', 2) for t in gold_tokens))
        decoded_forms, _, decoded_cats = zip(*(t.rsplit('|', 2) for t in decoded_tokens))
        assert gold_forms == decoded_forms
        for gold_cat, decoded_cat in zip(gold_cats, decoded_cats):
            cats_total += 1
            if gold_cat == decoded_cat:
                cats_correct += 1
    print('Cats total:', cats_total)
    print('Cats correct:', cats_correct)
    print('Accuracy:', cats_correct / cats_total)
