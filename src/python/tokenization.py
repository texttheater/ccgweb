#!/usr/bin/env python3


"""Wrapper for Ucto. Suppresses documents with multiple sentences.
"""


import re
import ucto


class Tokenizer:

    def __init__(self, lang):
        path = 'config/ucto/tokconfig-' + lang
        self.ucto = ucto.Tokenizer(path)

    def tokenize(self, text):
        self.ucto.process(text)
        tokens = list(self.ucto)
        if len(tokens) == 0:
            return ''
        if any(t.isendofsentence() for t in tokens[:-1]):
            # suppress document with multiple sentences
            return ''
        tokens = [str(t) for t in tokens]
        # HACK: "qualcos'" becomes "qua cos'" (why???), breaks alignment - drop those sentences
        if ''.join(tokens) != re.sub(r'\s', '', text):
            return ''
            #raise RuntimeError('Nomatch: {} {}'.format(repr(tokens), repr(line)))
        return ' '.join(str(t) for t in tokens)
