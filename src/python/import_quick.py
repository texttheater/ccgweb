import ccgweb
import ccgweb.sentences
import sys


if __name__ == '__main__':
    try:
        _, lang = sys.argv
    except ValueError:
        print('USAGE: cat sentences.txt | python3 import_quick.py LANG',
              file=sys.stderr)
        sys.exit(1)
    for line in sys.stdin:
        sentence, hsh = ccgweb.sentences.sentid(line)
        ccgweb.db.execute('''INSERT INTO sentences
                             (lang, sentence_id, sentence, assigned)
                             VALUES (%s, %s, %s, 1)
                             ON DUPLICATE KEY UPDATE
                             assigned = 1''', lang, hsh, sentence)
