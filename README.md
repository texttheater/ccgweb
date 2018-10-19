CCGWeb
======

CCGWeb is a Web platform for CCG parsing and annotation. It consists of three
parts:

* a natural language processing pipeline that turns raw text into CCG
  derivations, optionally aided by human annotation decisions
* a REST server
* a PHP frontend

Database
--------

The REST server requires a MySQL database to store its data. Assuming you want
to use a database called `ccgweb` on `localhost` with user `ccgweb` and password
`topsecret123`, this is how you can create it (enter the respective passwords
when asked):

    $ mysql -u root -p
    mysql> CREATE DATABASE ccgweb;
    mysql> GRANT ALL PRIVILEGES ON ccgweb.* TO 'ccgweb'@'localhost' IDENTIFIED BY 'topsecret123';
    mysql> EXIT;
    $ mysql -u ccgweb -p ccgweb < db_structure.sql

Also create a file `config.json` that contains your database credentials. Use
`config.json.sample` as a template.

Pipeline
--------

The pipeline is defined by the rules in `produce.ini`. Its output files are
dumped into the `out` directory. Its software dependencies must be placed into
the `ext` directory and models into the `models` directory before use.
Specifically, the following directories and files are expected to exist:

* `ext/easyccg/easyccg.jar`: the [Parallel Meaning Bank patched version of Mike
  Lewis’s EasyCCG parser](https://github.com/ParallelMeaningBank/easyccg)
* `models/parse/{eng,deu,ita,nld}.model`: EasyCCG models for English, German,
  Italian and Dutch.
* `ext/elephant`, the
  [Elephant](https://github.com/ParallelMeaningBank/elephant) tokenizer
* `models/tok.iob/{eng,deu,ita,nld}.model`, Elephant models for English,
  German, Italian and Dutch.
* `models/ud-2.2-conll18-baseline-models`,
  [models for UDPipe](http://ufal.mff.cuni.cz/udpipe#language_models)
  (used for tokenization)
* `ext/produce`, the [Produce](https://github.com/texttheater/produce) build
  system.
* `ext/viasock`, the [Viasock](https://github.com/texttheater/viasock)
  serverizer.

Further dependencies can be installed as follows on Ubuntu 16.04:

    sudo apt install python-lxml swi-prolog python3-pip
    pip3 install --user ufal.udpipe

REST API
--------

To install the dependencies for the REST server on Ubuntu 16.04:

    sudo apt install python3-falcon gunicorn3 python3-mysqldb python3-passlib python3-lxml

To start it:

    ./rest-server

PHP Frontend
------------

To install the dependencies for the PHP frontend on Ubuntu 16.04:

    sudo apt install php php-xsl composer
    cd site
    composer install
    cd ..

To create a test installation at `http://localhost/ccgweb`:

    sudo ln -s `pwd`/site /var/www/html/ccgweb

To create a config file:

    cp site/inc/config.inc.php.sample site/inc/config.inc.php
