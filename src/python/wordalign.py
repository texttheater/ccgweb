#!/usr/bin/env python


"""
Converts (M)GIZA++ output to a token-offset-based format.

Input example:

# Sentence pair (33977) source length 7 target length 8 alignment score : 4.28365e-07
can you give me your phone number ?
NULL ({ }) kan ({ 1 }) je ({ 2 }) mij ({ 4 }) je ({ 5 }) telefoonnummer ({ 6 7 }) geven ({ 3 }) ? ({ 8 }) 

Assuming the following raw texts:

Can you give me your phone number?

Kan je mij je telefoonnummer geven?

Output example:

0	3	0,3
4	6	4,7
7	10	13,15
11	13	16,20
14	28	21,16 27,33
29	34	8,12
34	35	33,34
"""


from __future__ import print_function


import os
import re
import sys
import toklib


# Matches a GIZA++ alignment line and extracts the bits between ({ and }).
ALIGN_PATTERN = re.compile(r'(?<=\(\{) ((?:\d+ )*)(?=}\))')


def trgid_list2english_offsets(trgid_list, english_sentence):
    english_offsets = []
    for trgid in trgid_list:
        eng_from = english_sentence[trgid - 1][0]
        eng_to = english_sentence[trgid - 1][1]
        english_offsets.append((eng_from, eng_to))
    english_offsets = ['{},{}'.format(*p) for p in english_offsets]
    english_offsets = ' '.join(english_offsets)
    return english_offsets


if __name__ == '__main__':
    try:
        _, lang, tid, sid = sys.argv
    except ValueError:
        print('USAGE: python wordalign.py LANG TARGET_ID SOURCE_ID',
              file=sys.stderr)
        sys.exit(1)
    # Read the offset pairs of the sentences:
    engoff_path = os.path.join('out', 'eng', sid[:2], sid, 'auto.tok.off')
    foroff_path = os.path.join('out', lang, tid[:2], tid, 'auto.tok.off')
    eng_offpairs = sorted(toklib.read_offset_file(engoff_path)[0], key=lambda x: x[0])
    for_offpairs = sorted(toklib.read_offset_file(foroff_path)[0], key=lambda x: x[0])
    if len(for_offpairs) > 100:
        print('WARNING: sentence too long for GIZA++, aborting', file=sys.stderr)
        sys.exit()
    # Find the position of the given sentence pair in the aligned corpus:
    engids_path = os.path.join('wordalign', 'eng-{}-train.eng.ids'.format(lang))
    forids_path = os.path.join('wordalign', 'eng-{}-train.{}.ids'.format(lang, lang))
    with open(engids_path) as engids, open(forids_path) as forids:
        for i, (engid, forid) in enumerate(zip(engids, forids), start=1):
            if engid.rstrip() == sid and forid.rstrip() == tid:
                break
        else:
            print('WARNING: no alignment found', file=sys.stderr)
            sys.exit()
    # Extract the alignment:
    dict_path = os.path.join('wordalign', '{}-eng-train.dict'.format(lang))
    with open(dict_path) as d:
        # Skip everything up to the line we need:
        for j in range(i - 1):
            d.readline()
            d.readline()
            d.readline()
        d.readline()
        d.readline()
        # Get a list of lists of target token IDs aligned to each
        # source token ID. The first element is the list of unaligned
        # target token IDs, so we ignore that.
        trgid_lists = [[int(i) for i in l.split()] for l
                       in ALIGN_PATTERN.findall(d.readline())][1:]
        #print(trgid_lists, len(trgid_lists), file=sys.stderr)
        #print(for_offpairs, len(for_offpairs), file=sys.stderr)
        assert len(trgid_lists) == len(for_offpairs)
        for for_token, trgid_list in zip(for_offpairs, trgid_lists):
            print(for_token[0], for_token[1],
                  trgid_list2english_offsets(trgid_list, eng_offpairs),
                  sep='\t')
