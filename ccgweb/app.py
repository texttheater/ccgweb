import ccgweb
import falcon


application = falcon.API()
application.add_route('/sentences/{sentence}', ccgweb.Sentence())
application.add_route('/login', ccgweb.Login())
application.add_route('/session', ccgweb.Session())
