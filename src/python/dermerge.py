#!/usr/bin/env python

"""
Takes a Boxer output XML file and a .tok.xml file and merges those <lexlist>
elements from the latter that correspond to sentences missing in the Boxer
output (because no parse) into the Boxer output. Used to be done by an XSL
stylesheet but apparently that was too inefficient.
"""

import re
import sys

idpattern = re.compile(r'\s+<der id="(\d+)">')

derxmlincomplete, tokxml = sys.argv[1:]

def chunkwise(derxmlfile):
    chunk = bytearray()
    with open(derxmlfile) as f:
        # Read XML file line by line (yes, this is assuming a particular
        # formatting):
        for line in f:
            stripline = line.strip()
            if stripline.startswith('<der ') or \
                    stripline.startswith('</xdrs-output>'):
                # yield old chunk, if any, and start new one with this line
                if chunk:
                    yield chunk
                    chunk = bytearray()
                chunk += line
            elif stripline.startswith('</der>'):
                # add line to chunk, yield it, start empty chunk
                chunk += line
                yield chunk
                chunk = bytearray()
            else:
                # add line to current chunk
                chunk += line
    yield chunk

dxichunks = list(chunkwise(derxmlincomplete))
tokxmlchunks = list(chunkwise(tokxml))

sys.stdout.write(dxichunks[0])
next_id = 1

for chunk in dxichunks[1:-1]:
    match = idpattern.match(chunk)
    current_id = int(match.group(1))
    while next_id < current_id:
        sys.stdout.write(tokxmlchunks[next_id])
        next_id += 1
    sys.stdout.write(chunk)
    next_id += 1

for i in range(next_id, len(tokxmlchunks) - 1):
    sys.stdout.write(tokxmlchunks[i])

sys.stdout.write(dxichunks[-1])
