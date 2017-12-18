import errno
import falcon
import os


from lxml import etree


def makedirs(path):
    try:
        os.makedirs(path)
    except OSError as error:
        if error.errno != errno.EEXIST:
            raise error


def slurp(path, encodings=('UTF-8',)):
    for encoding in encodings:
        try:
            with open(path, encoding=encoding) as f:
                return f.read()
        except UnicodeDecodeError:
            pass
    raise RuntimeError('File could not be read with any of the specified encodings.')


def fix_encoding(string):
    # Workaround for a character encoding bug affecting route components in
    # older versions of Falcon
    if int(falcon.__version__.split('.')[0]) < 1:
        return string.encode('Latin-1').decode('UTF-8')
    else:
        return string


def constituents(derxmlstring):
    constituents = set()
    tree = etree.fromstring(derxmlstring.encode('UTF-8'))
    for ruletype in ('binaryrule', 'unaryrule', 'lex'):
        for rule in tree.iter(ruletype):
            cats = rule.find('cat')
            if cats is None:
                continue
            cat = cat2string(cats[0])
            if ruletype == 'lex':
                fr = rule.findtext("tag[@type='from']")
                to = rule.findtext("tag[@type='to']")
            else:
                lexes = list(rule.iter('lex'))
                fr = lexes[0].findtext("tag[@type='from']")
                to = lexes[-1].findtext("tag[@type='to']")
            constituents.add((fr, to, cat))
    return constituents


def cat2string(cat, embedded=False):
    if cat.tag == 'atomic':
        return cat.text + feat_string(cat)
    elif cat.tag == 'backward':
        result = r'{}\{}'.format(cat2string(cat[0], embedded=True),
                cat2string(cat[1], embedded=True))
    elif cat.tag == 'forward':
        result = r'{}/{}'.format(cat2string(cat[0], embedded=True),
                cat2string(cat[1], embedded=True))
    else:
        die('unknown kind of CCG category: ' + cat.tag)
    if embedded:
        return '({})'.format(result)
    else:
        return result


def feat_string(cat):
    try:
        return '[' + cat.attrib['feature'] + ']'
    except KeyError:
        return ''
