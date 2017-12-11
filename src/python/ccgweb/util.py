import errno
import os


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
