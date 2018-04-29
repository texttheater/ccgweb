import ccgweb
import json


class Assignment:

    def on_get(self, req, res):
        user = ccgweb.users.current_user(req)
        if not user:
            user = 'auto'
        body = get_assignment(user)
        res.content_type = 'application/json'
        res.body = json.dumps(body)


def get_assignment(user):
    rows = ccgweb.db.get('''SELECT s.lang AS lang,
        s.sentence AS sentence,
        c.time IS NOT NULL AS done,
        (SELECT COUNT(*) FROM correct AS d WHERE d.lang = s.lang AND d.sentence_id = s.sentence_id AND d.user_id NOT IN ('auto', 'testuser', 'proj', 'xl', 'judge')) < 2 AS needs_annotation
        FROM sentences AS s
        LEFT OUTER JOIN correct AS c
        ON s.lang = c.lang
        AND s.sentence_id = c.sentence_id
        AND c.user_id = %s
        WHERE s.assigned > 0''', user)
    return [ { 'lang': lang, 'sentence': sentence.rstrip(), 'done': bool(done), 'needs_annotation': bool(needs_annotation) }
             for lang, sentence, done, needs_annotation in rows ]
