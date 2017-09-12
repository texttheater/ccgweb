import ccgweb


from passlib.context import CryptContext


ctx = CryptContext(schemes=['pbkdf2_sha256'])


def add_user(name, password):
    password_hash = ctx.encrypt(password)
    ccgweb.db.execute('''INSERT INTO users (id, password_hash)
                         VALUES (%s, %s)''', name, password_hash)
