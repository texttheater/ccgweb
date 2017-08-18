import ccgweb
import falcon


def create_app():
    api = falcon.API()
    api.add_route('/sentences/{sentence}', ccgweb.Sentence())
    return api


def get_app():
    return create_app()
