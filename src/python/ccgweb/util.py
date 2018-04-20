import ccgweb
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


def quadrilingual_sample(k):
    rows = ccgweb.db.get('''SELECT p1.sentence_id AS eng, p2.sentence_id AS deu, p3.sentence_id AS ita, p4.sentence_id AS nld
                            FROM sentence_pmbids AS p1
                            INNER JOIN sentence_pmbids AS p2 USING (pmb_part, pmb_doc_id)
                            INNER JOIN sentence_pmbids AS p3 USING (pmb_part, pmb_doc_id)
                            INNER JOIN sentence_pmbids AS p4 USING (pmb_part, pmb_doc_id)
                            WHERE p1.lang = 'eng'
                            AND p2.lang = 'deu'
                            AND p3.lang = 'ita'
                            AND p4.lang = 'nld'
                            ORDER BY RAND()
                            LIMIT %s''', k)
    docs = []
    for eng, deu, ita, nld in rows:
        docs.append(('eng', eng))
        docs.append(('deu', deu))
        docs.append(('ita', ita))
        docs.append(('nld', nld))
    return docs
