#!/usr/bin/env python


from __future__ import print_function


import sys
import toklib


def conflict(span1, span2):
    from1, to1 = span1
    from2, to2 = span2
    if from1 < from2 < to1 < to2:
        return True
    if from2 < from1 < to2 < to1:
        return True
    return False


def matches(span, tokens):
    span_from, span_to = span
    if not any(True for token_from, token_to in tokens if span_from == token_from):
        return False
    if not any(True for token_from, token_to in tokens if span_to == token_to):
        return False
    return True


if __name__ == '__main__':
    # Process command line:
    try:
        _, bowfile, offfile = sys.argv
    except ValueError:
        print('USAGE: python3 bows_span by BOWFILE OFFFILE',
              file=sys.stderr)
        sys.exit(1)
    # Read spans and tokens:
    spans = list(toklib.read_offset_pairs(bowfile))
    tokens = list(toklib.read_offset_pairs(offfile))
    # Eliminate conflicting spans, later spans take precedence:
    old_spans = spans
    spans = []
    for span in old_spans:
        spans = [s for s in spans if not conflict(s, span) and not s == span]
        spans.append(span)
    # Eliminate spans that do not match token boundaries:
    spans = [span for span in spans if matches(span, tokens)]
    # Output parens indicating how many spans end and begin at each token:
    for token_from, token_to in tokens:
        parens = []
        for span_from, span_to in spans:
            if token_from == span_from:
                parens.append('(')
        for span_from, span_to in spans:
            if token_to == span_to:
                parens.append(')')
        print(''.join(parens))
