import json
import MySQLdb


class DB:

    def __init__(self, conn):
        self.conn = conn

    def get(self, sql, *args):
        with self.conn as cursor:
            cursor.execute(sql, args)
            return cursor.fetchall()

    def execute(self, sql, *args):
        with self.conn as cursor:
            cursor.execute(sql, args)


with open('config.json') as f:
    config = json.load(f)


db = DB(MySQLdb.connect(config['db_host'], config['db_user'],
                        config['db_pass'], config['db_name'],
                        charset='utf8'))
