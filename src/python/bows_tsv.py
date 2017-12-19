#!/usr/bin/env python3


import ccgweb
import sys


if __name__ == '__main__':
    try:
        _, lang, sid, uid, layer = sys.argv
    except ValueError:
        print('USAGE: python3 bows_super.py LANG SID UID LAYER', file=sys.stderr)
        sys.exit(1)
    if layer == 'super':
        bows = ccgweb.db.get('''SELECT offset_from, offset_to, tag
                                FROM bows_super
                                WHERE lang = %s
                                AND sentence_id = %s
                                AND user_id = %s
                                ORDER BY time ASC''', lang, sid, uid)
        for offset_from, offset_to, tag in bows:
            print(offset_from, offset_to, tag)
    elif layer == 'span':
        bows = ccgweb.db.get('''SELECT offset_from, offset_to
                                FROM bows_span
                                WHERE lang = %s
                                AND sentence_id = %s
                                AND user_id = %s
                                ORDER BY time ASC''', lang, sid, uid)
        for offset_from, offset_to in bows:
            print(offset_from, offset_to)
    elif layer == 'tok':
        bows = ccgweb.db.get('''SELECT offset, tag
                                FROM bows_tok
                                WHERE lang = %s
                                AND sentence_id = %s
                                AND user_id = %s
                                ORDER BY time ASC''', lang, sid, uid)
        for offset, tag in bows:
            print(offset, tag)
    else:
        print('ERROR: unknown layer:', layer, file=sys.stderr)
        sys.exit(1)
