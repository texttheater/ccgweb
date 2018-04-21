import ccgweb
import falcon
import json
import uuid


from passlib.context import CryptContext


ctx = CryptContext(schemes=['pbkdf2_sha256'])


class Session:

    def on_get(self, req, res):
        session_id = req.cookies['session_id']
        body = ccgweb.users.get_session_info(session_id)
        res.body = json.dumps(body)

    def on_post(self, req, res):
        if 'api_action' not in req.params:
            res.status = falcon.HTTP_400
            return
        if req.params['api_action'] == 'login':
            session_id = ccgweb.users.login(req.params['user_id'],
                                            req.params['password'])
            if session_id:
                # TODO move this info to Set-Cookie header?
                body = { 'session_id': session_id }
                res.body = json.dumps(body)
            else:
                res.status = falcon.HTTP_401
        elif req.params['api_action'] == 'logout':
            try:
                session_id = req.cookies['session_id']
            except ValueError:
                res.status = falcon.HTTP_400
                return
            ccgweb.users.logout(session_id)
        else:
            res.status = falcon.HTTP_400
            return


def add_user(name, password):
    password_hash = ctx.encrypt(password)
    ccgweb.db.execute('''INSERT INTO users (id, password_hash)
                         VALUES (%s, %s)''', name, password_hash)


def change_password(user_name, password):
    password_hash = ctx.encrypt(password)
    ccgweb.db.execute('''UPDATE users
                         SET password_hash = %s
                         WHERE id = %s''', password_hash, user_name)


def login(name, password):
    rows = ccgweb.db.get('''SELECT password_hash FROM users
                            WHERE id = %s''', name)
    if not rows:
        return
    if not ctx.verify(password, rows[0][0]):
        return
    session_id = uuid.uuid4().hex
    ccgweb.db.execute('''UPDATE users
                         SET session_id = %s,
                         session_expires = NOW() + INTERVAL 1 YEAR
                         WHERE id = %s''', session_id, name)
    return session_id


def logout(session_id):
    ccgweb.db.execute('''UPDATE users
                         SET session_id = NULL
                         WHERE session_id = %s''', session_id)


def get_session_info(session_id):
    rows = ccgweb.db.get('''SELECT id FROM users
                            WHERE session_id = %s''', session_id)
    if not rows:
        return
    return { 'user_id': rows[0][0] }


def current_user(req):
    if not 'session_id' in req.cookies:
        return None
    session_id = req.cookies['session_id']
    rows = ccgweb.db.get('''SELECT id FROM users
                            WHERE session_id = %s''', session_id)
    if not rows:
        return None
    return rows[0][0]


def clone_bows(src_user, dst_user):
    """Clones src_user's BOWs as dst_user's BOWs."""
    ccgweb.db.execute('''INSERT INTO bows_span
                         (user_id, time, lang, sentence_id, offset_from, offset_to)
                         SELECT %s, time, lang, sentence_id, offset_from, offset_to
                         FROM bows_span
                         WHERE user_id = %s''', dst_user, src_user)
    ccgweb.db.execute('''INSERT INTO bows_super
                         (user_id, time, lang, sentence_id, offset_from, offset_to, tag)
                         SELECT %s, time, lang, sentence_id, offset_from, offset_to, tag
                         FROM bows_super
                         WHERE user_id = %s''', dst_user, src_user)
