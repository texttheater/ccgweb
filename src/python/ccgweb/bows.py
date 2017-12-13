import ccgweb
import json


class BOWs:

    def on_get(self, req, res):
        span_bows = ccgweb.db.get('''SELECT user_id, DATE_FORMAT(time, '%%Y-%%m-%%e %%H:%%i:%%s') AS time, lang, sentence_id, offset_from, offset_to
                                     FROM bows_span''')
        super_bows = ccgweb.db.get('''SELECT user_id, DATE_FORMAT(time, '%%Y-%%m-%%e %%H:%%i:%%s') AS time, lang, sentence_id, offset_from, offset_to, tag
                                      FROM bows_super''')
        sentences = set()
        sentences.update((lang, sentence_id)
                         for (user_id, time, lang, sentence_id, offset_from, offset_to)
                         in span_bows)
        sentences.update((lang, sentence_id)
                         for (user_id, time, lang, sentence_id, offset_from, offset_to, tag)
                         in super_bows)
        keys = list(sentences)
        sentences = {(lang, sentence_id): {'span_bows': [], 'super_bows': [], 'pmb': []}
                     for lang, sentence_id in sentences}
        for user_id, time, lang, sentence_id, offset_from, offset_to in span_bows:
            sentences[(lang, sentence_id)]['span_bows'].append({
                'user_id': user_id,
                'time': time,
                'offset_from': offset_from,
                'offset_to': offset_to
            })
        for user_id, time, lang, sentence_id, offset_from, offset_to, tag in super_bows:
            sentences[(lang, sentence_id)]['super_bows'].append({
                'user_id': user_id,
                'time': time,
                'offset_from': offset_from,
                'offset_to': offset_to,
                'tag': tag
            })
        mapping = ccgweb.db.get('''SELECT lang, sentence_id, sentence
                                   FROM sentences
                                   WHERE (lang, sentence_id) IN %s''', keys)
        for lang, sentence_id, sentence in mapping:
            sentences[(lang, sentence_id)]['lang'] = lang
            sentences[(lang, sentence_id)]['sentence'] = sentence
        mapping = ccgweb.db.get('''SELECT lang, sentence_id, pmb_part, pmb_doc_id
                                   FROM sentence_pmbids
                                   WHERE (lang, sentence_id) in %s''', keys)
        for lang, sentence_id, part, doc_id in mapping:
            sentences[(lang, sentence_id)]['pmb'].append('{}/{}'.format(part, doc_id))
        res.content_type = 'application/json'
        res.body = json.dumps(list(sentences.values()))
