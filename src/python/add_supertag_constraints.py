#!/usr/bin/env python


import sys


if __name__ == '__main__':
    try:
        _, supertagfile = sys.argv
    except ValueError:
        print >> sys.stderr, 'USAGE: cat text.tok | python add_supertag_constraints.py text.super'
        sys.exit(1)
    with open(supertagfile) as f:
        supertags = [line.rstrip() for line in f]
    for line in sys.stdin:
        tokens = line.split()
        sentence_supertags, supertags = supertags[:len(tokens)], supertags[len(tokens):]
        tokens = ['{}|{}'.format(token, supertag) for token, supertag in zip(tokens, sentence_supertags)]
        print(' '.join(tokens))
    if supertags:
        print >> sys.stderr, 'ERROR: more supertags than tokens'
        sys.exit(1)
