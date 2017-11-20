import ccgweb
import json


class Assignment:

    def on_get(self, req, res):
        user = ccgweb.users.current_user(req)
        if not user:
            user = 'auto'
        body = [ { 'lang': lang, 'sentence': sentence, 'done': done }
                 for lang, sentence, done in get_assignment(user) ]
        res.content_type = 'application/json'
        res.body = json.dumps(body)


def get_assignment(user):
    return ccgweb.db.get('''SELECT s.lang AS lang,
        s.sentence AS sentence,
        c.time IS NOT NULL AS done
        FROM sentences AS s
        LEFT OUTER JOIN correct AS c
        ON s.lang = c.lang
        AND s.sentence_id = c.sentence_id
        AND c.user_id = %s
        WHERE s.assigned > 0''', user)
