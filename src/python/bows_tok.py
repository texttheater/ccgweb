#!/usr/bin/env python3


import ccgweb
import sys


if __name__ == '__main__':
    try:
        _, bowfile = sys.argv
    except ValueError:
        print('USAGE: python3 bows_tok.py bowfile', file=sys.stderr)
        sys.exit(1)
    effective_bow_by_offset = {}
    with open(bowfile) as f:
        for line in f:
            offset, tag = line.split()
            offset = int(offset)
            effective_bow_by_offset[offset] = tag
    started = False
    for offset, line in enumerate(sys.stdin):
        if not line.rstrip():
            continue
        code, label = line.split()
        if offset in effective_bow_by_offset:
            label = effective_bow_by_offset[offset]
        # Fix invalid sequences by changing the first I or T to an S if no S
        # has occurred yet:
        if not started:
            if label in ('I', 'T'):
                label = 'S'
            if label == 'S':
                started = True
        print(code, label)
