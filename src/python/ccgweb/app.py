import ccgweb
import falcon


application = falcon.API()

if hasattr(application.req_options, 'auto_parse_form_urlencoded'):
    application.req_options.auto_parse_form_urlencoded = True

application.add_route('/sentences/{lang}/{sentence}/{user_id}', ccgweb.Sentence())
application.add_route('/session', ccgweb.Session())
