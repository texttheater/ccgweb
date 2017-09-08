#!/usr/bin/env python3


import sys


if __name__ == '__main__':
    try:
        _, bowfile, offfile = sys.argv
    except ValueError:
        print('USAGE: python3 bows_super.py BOWFILE OFFFILE',
              file=sys.stderr)
        sys.exit(1)
    tag_by_offsets = {}
    with open(bowfile) as f:
        for line in f:
            offset_from, offset_to, tag = line.split()
            tag_by_offsets[(offset_from, offset_to)] = tag
    with open(offfile) as f:
        for line in f:
            offset_from, offset_to, tokid, tok = line.split(maxsplit=3)
            if (offset_from, offset_to) in tag_by_offsets:
                print(tag)
            else:
                print()
