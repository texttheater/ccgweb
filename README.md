CCGWeb
======

CCGWeb is a web application that lets users enter sentences, parses them and
lets users modify the parses.

Installation
------------

Make sure the subdirectory `ext` exists and contains the following Git
repositories as subdirectories:

* [easyccg](https://github.com/ParallelMeaningBank/easyccg)
* [elephant](https://github.com/ParallelMeaningBank/elephant)
* [produce](https://github.com/texttheater/produce)
* [viasock](https://github.com/texttheater/viasock)

In addition, Boxer 2 is needed. The binary should be placed as
`ext/boxer/boxer2`.

The EasyCCG parser and the Elephant tokenizer need models. These should be
made available as directories at `models/parse/en.model` and
`models/tok.iob/en.model`, respectively. Default models are provided on the
respective tools web site.

Create the subdirectories `out` and `log` and make sure your Web server can
write to them.

You should also make sure that the contents of `ext`, `log` and `models` are
not exposed by the Web server. For example, if you are using Apache, this can
usually be accomplished by placing a file called `.htaccess` in each of these
directories with the following contents:

    deny from all
