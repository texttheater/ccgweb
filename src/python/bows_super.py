#!/usr/bin/env python3


import ccgweb
import sys


if __name__ == '__main__':
    try:
        _, sid, uid, off = sys.argv
    except ValueError:
        print('USAGE: python3 bows_super.py SID UID OFFFILE', file=sys.stderr)
        sys.exit(1)
    bows = ccgweb.db.get('''SELECT offset_from, offset_to, tag
                            FROM bows_super
                            WHERE sentence_id = %s
                            AND user_id = %s''', sid, uid)
    tag_by_offsets = {}
    for offset_from, offset_to, tag in bows:
        tag_by_offsets[(offset_from, offset_to)] = tag
    with open(off) as f:
        for line in f:
            offset_from, offset_to, tokid, tok = line.split(maxsplit=3)
            if (offset_from, offset_to) in tag_by_offsets:
                print(tag)
            else:
                print()
