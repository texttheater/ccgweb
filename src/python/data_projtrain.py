#!/usr/bin/env python3


import argparse
import ccgweb
import ccgweb.sentences


if __name__ == '__main__':
    parser = argparse.ArgumentParser(description='''Extracts projected
        derivations from CCGweb''')
    parser.add_argument('lang', choices=('deu', 'ita', 'nld'), help='''the
        language to extract for''')
    parser.add_argument('train', help='''file to put training derivations
        into''')
    parser.add_argument('dev', help='''file to put development derivations
        into''')
    args = parser.parse_args()
    trainfile = open(args.train, 'w')
    devfile = open(args.dev, 'w')
    rows = ccgweb.db.get('''SELECT l.id1, l.id2
                            FROM sentence_links AS l
                            INNER JOIN sentences AS s1
                            ON l.lang1 = s1.lang
                            AND l.id1 = s1.sentence_id
                            INNER JOIN sentences AS s2
                            ON l.lang2 = s2.lang
                            AND l.id2 = s2.sentence_id
                            WHERE l.lang1 = 'eng'
                            AND l.lang2 = %s
                            AND s1.assigned = 0
                            AND s2.assigned = 0''', args.lang)
    for engid, forid in rows:
        infile = ccgweb.sentences.get_proj_path(args.lang, forid, engid,
            'train', 'parse.tags')
        with open(infile) as f:
                contents = f.read()
        # XXX dev sentences are not included yet
        if False:
            devfile.write(contents)
        else:
            trainfile.write(contents)
        
