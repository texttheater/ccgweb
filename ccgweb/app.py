import ccgweb
import falcon


application = falcon.API()
application.add_route('/sentences/{sentence}', ccgweb.Sentence())
