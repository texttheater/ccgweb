#!/usr/bin/env python3


"""Wrapper for tokenizers. Suppresses documents with multiple sentences.
"""


import sys
#import ucto
import ufal.udpipe


lang_model_map = {
    'ara': 'arabic-padt',
    'ces': 'czech-pdt',
    'dan': 'danish-ddt',
    'deu': 'german-gsd',
    'eng': 'english-ewt',
    'eus': 'basque-bdt',
    'ita': 'italian-isdt',
    'nld': 'dutch-alpino',
    'por': 'portuguese-bosque',
    'slv': 'slovenian-ssj',
    'swe': 'swedish-talbanken',
}


def tokenize(texts, lang):
    return tokenize_udpipe(texts, lang)
    #if lang in ('eng', 'fra', 'deu', 'ita', 'nld', 'por', 'rus', 'spa', 'swe', 'tur'):
    #    return tokenize_ucto(texts, lang)
    #else:
    #    return tokenize_udpipe(texts, lang)


def tokenize_ucto(texts, lang):
    t = UctoTokenizer(lang)
    return tuple(t.tokenize(text) for text in texts)


class UctoTokenizer:

    def __init__(self, lang):
        path = 'ext/uctodata/config/tokconfig-' + lang
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


def tokens(sentence):
    mit = iter(sentence.multiwordTokens)
    wit = iter(sentence.words)
    while True:
        try:
            m = next(mit)
        except StopIteration:
            yield from (w.form for w in wit)
            return
        try:
            w = next(wit)
        except StopIteration:
            yield m.form
            continue
        while w.id < m.idFirst:
            yield w.form
            w = next(wit)
        yield m.form
        for i in range(m.idLast - m.idFirst):
            next(wit)


def tokenize_udpipe(texts, lang):
    path = 'models/ud-2.2-conll18-baseline-models/models/{}-ud-2.2-conll18-180430.udpipe'.format(lang_model_map[lang])
    model = ufal.udpipe.Model_load(path)
    if model is None:
        raise RuntimeError('Failed to load model. Make sure file {} exists.'.format(path))
    t = model.newTokenizer('')
    s = ufal.udpipe.Sentence()
    result = []
    for i, text in enumerate(texts, start=1):
        if i % 100 == 0:
            print(lang, i)
        t.setText(text)
        sentences = []
        while t.nextSentence(s):
            words = []
            words.extend(tokens(s)) # alternative implementation commented out below
            #for w in s.words:
            #    multi = False
            #    for m in s.multiwordTokens:
            #        if m.idFirst <= w.id <= m.idLast:
            #            if m.idFirst == w.id:
            #                words.append(m.form)
            #            multi = True
            #            break
            #    if not multi:
            #        words.append(w.form)
            sentences.append(' '.join(words[1:]))
        if len(sentences) != 1:
            result.append('')
        else:
            result.append(sentences[0])
    return result
