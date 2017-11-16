import ccgweb
import json


class Assignment:

    def on_get(self, req, res):
        rows = ccgweb.db.get('''SELECT s.lang AS lang,
            s.sentence AS sentence,
            c.time IS NOT NULL AS done
            FROM sentences AS s
            LEFT OUTER JOIN correct AS c
            ON s.lang = c.lang
            AND s.sentence_id = c.sentence_id
            WHERE s.assigned > 0''')
        body = [ { 'lang': lang, 'sentence': sentence, 'done': done }
                 for lang, sentence, done in rows ]
        res.content_type = 'application/json'
        res.body = json.dumps(body)
