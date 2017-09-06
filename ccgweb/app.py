import ccgweb
import falcon
import json
import MySQLdb


with open('config.json') as f:
    config = json.load(f)


db = MySQLdb.connect(config['db_host'], config['db_user'], config['db_pass'],
                     config['db_name'])


application = falcon.API()
application.add_route('/sentences/{sentence}', ccgweb.Sentence(db))
