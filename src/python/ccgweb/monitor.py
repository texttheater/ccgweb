import ccgweb
import json


class Monitor:

    def on_get(self, req, res):
        user = ccgweb.users.current_user(req)
        if user != 'judge':
            res.status = falcon.HTTP_401
            return
        rows = ccgweb.db.get('''SELECT c.user_id, c.lang, COUNT(*)
                                FROM correct AS c
                                INNER JOIN sentences AS s
                                ON c.lang = s.lang
                                AND c.sentence_id = s.sentence_id
                                WHERE s.assigned = 1
                                GROUP BY c.user_id, c.lang''')
        body = []
        for user_id, lang, count in rows:
            body.append({'user_id': user_id, 'lang': lang, 'count': count})
        res.content_type = 'application/json'
        res.body = json.dumps(body)
