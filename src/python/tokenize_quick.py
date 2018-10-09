#!/usr/bin/env python3


"""Minimalistic category-based tokenization.
"""


import sys
import unicodedata


if __name__ == '__main__':
    s = sys.stdin.read()
    previous = None
    sentence = False
    for c in s:
        cat = unicodedata.category(c)[:1]
        if cat == 'M':
            cat = 'L'
        if c in "’'" and previous == 'L':
            label = 'I'
        elif cat.startswith('Z'):
            label = 'O'
        elif cat.startswith('P'):
            label = 'T'
        elif previous == cat:
            label = 'I'
        else:
            label = 'T'
        if label == 'T' and not sentence:
            label = 'S'
            sentence = True
        print('{} {}'.format(ord(c), label))
        previous = cat
    print()
