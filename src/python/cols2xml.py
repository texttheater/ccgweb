#!/usr/bin/env python

"""Input format: columns: tokid, word form, tags"""

import sys
import toklib

from xml.sax.saxutils import escape

print '<?xml version="1.0" encoding="UTF-8"?>'
print '<!DOCTYPE tokenization SYSTEM "src/data/boxer/tokenization.dtd">'
print '<tokenization>'

tag_types = sys.argv[1:]
max_snum = 0

lines_by_snum = {}

for line in sys.stdin:
    if line.endswith('\n'):
        line = line[:-1]
    fields = line.split('\t')
    tokid = fields[0]
    snum = int(tokid[:-3])
    max_snum = max(snum, max_snum)
    if not snum in lines_by_snum:
        lines_by_snum[snum] = []
    lines_by_snum[snum].append(fields)

for i in xrange(max_snum):
    snum = i + 1
    print ' <der id="%d">' % snum
    print '  <lexlist>'
    for fields in lines_by_snum[snum]:
        tokid = fields[0]
        form = fields[1]
        tags = fields[2:]
        print '   <lex id="%s">' % tokid
        print '    <token>%s</token>' % escape(form)
        for i in xrange(len(tag_types)):
            if tags[i]:
                print '    <tag type="%s">%s</tag>' \
                        % (escape(tag_types[i]), escape(tags[i]))
        print '   </lex>'
    print '  </lexlist>'
    print ' </der>'

print '</tokenization>'
