import json
import MySQLdb


class DB:

    def __init__(self, host, user, password, name):
        self.host = host
        self.user = user
        self.password = password
        self.name = name
        self.conn = None

    def _connect(self):
        self.conn = MySQLdb.connect(self.host, self.user, self.password,
                                    self.name, charset='utf8mb4')

    def get(self, sql, *args):
        try:
            with self.conn as cursor:
                cursor.execute(sql, args)
                return cursor.fetchall()
        except (AttributeError, MySQLdb.OperationalError):
            self._connect()
            with self.conn as cursor:
                cursor.execute(sql, args)
                return cursor.fetchall()

    def execute(self, sql, *args):
        try:
            with self.conn as cursor:
                cursor.execute(sql, args)
        except (AttributeError, MySQLdb.OperationalError):
            self._connect()
            with self.conn as cursor:
                cursor.execute(sql, args)


with open('config.json') as f:
    config = json.load(f)


db = DB(config['db_host'], config['db_user'],
        config['db_pass'], config['db_name'])
