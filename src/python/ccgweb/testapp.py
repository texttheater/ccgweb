import falcon

class String:

    def on_get(self, req, res, string):
        print(string)

application = falcon.API()
application.add_route('/{string}', String())
