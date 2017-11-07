import ccgweb
import falcon


application = falcon.API()
application.req_options.auto_parse_form_urlencoded = True
application.add_route('/sentences/{sentence}/{user_id}', ccgweb.Sentence())
application.add_route('/login', ccgweb.Login())
application.add_route('/session', ccgweb.Session())
