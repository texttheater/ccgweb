CCGWeb
======

CCGWeb is a web application that lets users enter sentences, parses them and
lets users modify the parses.

Installing a Development Version
--------------------------------

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

The Web server needs to be able to create and modify files in the `.viasock`,
`log` and `out` subdirectories. The developer should be able to do the same
from his or her own account, and both should not clash. On Ubuntu with Apache,
this can be ensured by running the following commands *before* those three
directories are created:

    sudo usermod -a -G www-data $USER # add user to www-data group
    chown :www-data . # change group of ccgweb directory to www-data
    chmod g+s . # set setgid bit on the ccgweb directory

Running the Development Version
-------------------------------

    php -S localhost:8080

Deploying to a Public Web Server
--------------------------------

TODO

* protect sensitive directories (`log`, `models`, `src`)
* make sure the Web server can write to `log` and `models`
