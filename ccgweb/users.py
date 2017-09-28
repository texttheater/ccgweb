import ccgweb
import uuid


from passlib.context import CryptContext


ctx = CryptContext(schemes=['pbkdf2_sha256'])


def add_user(name, password):
    password_hash = ctx.encrypt(password)
    ccgweb.db.execute('''INSERT INTO users (id, password_hash)
                         VALUES (%s, %s)''', name, password_hash)


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


def get_session_info(session_id):
    rows = ccgweb.db.get('''SELECT id FROM users
                            WHERE session_id = %s''', session_id)
    if not rows:
        return
    return { 'user_id': rows[0][0] }
