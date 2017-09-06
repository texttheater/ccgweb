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
`topsecret123`, this is how you can create it:
it:

    $ mysql -u root -p
    mysql> CREATE DATABASE ccgweb;
    mysql> GRANT ALL PRIVILEGES ON ccgweb.* TO 'ccgweb'@'localhost' IDENTIFIED BY 'topsecret123';
    mysql> EXIT;

TODO create tables

Also create a file `config.json` that contains your database credentials. Use
`config.json.sample` as a template.

Pipeline
--------

The pipeline is defined by the rules in `produce.ini`. Its output files are
dumped into the `out` directory. Its software dependencies must be placed into
the `ext` directory and models into the `models` directory before use.
Specifically, the following directories and files are expected to exist:

* `ext/boxer/boxer2`, the Boxer 2 binary by Johan Bos. Requires the
  [SWI-Prolog](http://www.swi-prolog.org) 7 runtime library to be installed.
* `ext/easyccg`: the [Parallel Meaning Bank patched version of Mike Lewis’s
  EasyCCG parser](https://github.com/ParallelMeaningBank/easyccg)
* `models/parse/en.model`: the EasyCCG model trained on the Rebanked CCGbank,
  available via the
  [EasyCCG website](http://homepages.inf.ed.ac.uk/s1049478/easyccg.html).
* `ext/elephant`, the
  [https://github.com/ParallelMeaningBank/elephant](Elephant) tokenizer
* `models/tok.iob/en.model`, an Elephant model for English, available via the
  [Elephant website](http://gmb.let.rug.nl/elephant/about.php).
* `ext/produce`, the [Produce](https://github.com/texttheater/produce) build
  system.
* `ext/viasock`, the [Viasock](https://github.com/texttheater/produce)
  serverizer.

REST API
--------

To install the dependencies for the REST server on Ubuntu 16.04:

    sudo apt install python3-falcon gunicorn3 python3-mysqldb

To start it:

    ./start-rest-server

PHP Frontend
------------

To install the dependencies for the PHP frontend on Ubuntu 16.04:

    sudo apt install php php-xsl composer
    cd site
    composer install
    cd ..

To create a test installation at `http://localhost/ccgweb`:

    sudo ln -s /var/www/html/ccgweb site

To create a config file:

    cp site/config.inc.php.sample site/config.inc.php
