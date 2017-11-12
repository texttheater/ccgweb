#!/usr/bin/env python


import sys


def add_parens(token, parens):
    try:
        index = parens.index(')')
    except ValueError:
        return ' '.join(parens + [token])
    return ' '.join(parens[:index] + [token] + parens[index:])


if __name__ == '__main__':
    try:
        _, spanfile = sys.argv
    except ValueError:
        print >> sys.stderr, 'USAGE: cat text.tok | python add_span_constraints.py text.spans'
        sys.exit(1)
    with open(spanfile) as f:
        parenss = [line.split() for line in f]
    for line in sys.stdin:
        tokens = line.split()
        sentence_parenss, parenss = parenss[:len(tokens)], parenss[len(tokens):]
        tokens = [add_parens(token, parens) for token, parens in zip(tokens, sentence_parenss)]
        print(' '.join(tokens))
    if parenss:
        print >> sys.stderr, 'ERROR: span file has more lines than there are tokens'
        sys.exit(1)
