import ccgweb
import itertools
import json


class Download:

    def on_get(self, req, res):
        rows = ccgweb.db.get('''SELECT s.lang, s.sentence_id, s.sentence,
                                c.user_id, c.derxml
                                FROM sentences AS s
                                INNER JOIN correct AS c
                                ON (c.lang, c.sentence_id) = (s.lang, s.sentence_id)
                                WHERE s.assigned = 1
                                ORDER BY c.lang, c.sentence_id''')
        groups = itertools.groupby(rows, lambda x: x[:3]) # group by sentence
        body = []
        for (lang, sentence_id, sentence), group in groups:
            rows = ccgweb.db.get('''SELECT pmb_part, pmb_doc_id
                                    FROM sentence_pmbids
                                    WHERE lang = %s
                                    AND sentence_id = %s''', lang, sentence_id)
            pmb = ['{}/{}'.format(*row) for row in rows]
            sentence = {'lang': lang, 'sentence': sentence, 'pmb': pmb,
                        'annotations': []}
            for _, _, _, user_id, derxml in group:
                sentence['annotations'].append({'user_id': user_id, 'derxml': derxml})
            body.append(sentence)
        res.content_type = 'application/json'
        res.body = json.dumps(body)
