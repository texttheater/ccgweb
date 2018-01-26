import ccgweb.assignments
import ccgweb.bows
import ccgweb.download
import ccgweb.monitor
import ccgweb.sentences
import ccgweb.users
import falcon


application = falcon.API()

if hasattr(application.req_options, 'auto_parse_form_urlencoded'):
    application.req_options.auto_parse_form_urlencoded = True

application.add_route('/sentences/{lang}/{sentence}', ccgweb.sentences.Sentence())
application.add_route('/session', ccgweb.users.Session())
application.add_route('/assignment', ccgweb.assignments.Assignment())
application.add_route('/bows', ccgweb.bows.BOWs())
application.add_route('/download', ccgweb.download.Download())
application.add_route('/monitor', ccgweb.monitor.Monitor())
