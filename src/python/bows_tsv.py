#!/usr/bin/env python3


import ccgweb
import sys


if __name__ == '__main__':
    try:
        _, sid, uid, layer = sys.argv
    except ValueError:
        print('USAGE: python3 bows_super.py SID UID LAYER', file=sys.stderr)
        sys.exit(1)
    if layer == 'super':
        bows = ccgweb.db.get('''SELECT offset_from, offset_to, tag
                                FROM bows_super
                                WHERE sentence_id = %s
                                AND user_id = %s''', sid, uid)
        for offset_from, offset_to, tag in bows:
            print(offset_from, offset_to, tag)
    else:
        print('ERROR: unknown layer:', layer, file=sys.stderr)
        sys.exit(1)