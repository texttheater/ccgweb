#!/usr/bin/env python

"""
Takes parses in the format produced by easyCCG with -o boxer as input on STDIN
and replaces/adds tags in the tag list. Command line arguments are:

1) The path to the .tok.off file for reference, needed for synchronizing parses
   with tokens
2) The tag layer to be modified, e.g. lemma or sem
3) The path to the file containing the tag for each token - one token per line,
   tag must be in the first, tab-separated column.

Arguments 2 and 3 may be repeated alternatingly for other tagging layers.
"""

import caclib
import codecs
import sys
import toklib
import utils

tags = {}

(tokens, boundaries) = toklib.read_offset_file(sys.argv[1], ids=True)
tokens = list(tokens)
tokens.sort()

for (type, path) in utils.pairwise(sys.argv[2:]):
    i = 0
    tags[type] = {}
    with codecs.open(path, 'r', encoding='UTF-8') as f:
       for line in f:
           line = line.rstrip()
           (fr, to, snum, tnum) = tokens[i]
           i += 1
           if line or type == 'sense': # HACK, really set sense tag to the empty string to prevent Boxer from filling in default 1
               tags[type][(snum, tnum)] = line.split('\t', 1)[0]

out = utils.write_utf8()
tnum = 0
for line in utils.read_utf8():
    new_snum = caclib.snum(line)
    if new_snum != None:
        snum = new_snum
        tnum = 0
    token = caclib.token(line)
    if token:
        tnum += 1
        for type in tags:
            if (snum, tnum) in tags[type]:
                token.tags[type] = tags[type][(snum, tnum)]
        out.write(token.line())
    else:
        out.write(line)
