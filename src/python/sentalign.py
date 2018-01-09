#!/usr/bin/env python

'''
Generate sentence alignment files for each language.
This is meant to be a preliminary step, using a 1:1 heuristic.
In the future, this should be replaced by a more sophisticated tool,
such as, e.g., hunalign.

BoWs are of this format:
(part, doc_id, english_from, english_to, foreign_from, foreign_to, language_code)

The output here should be:
eng_from<TAB>eng_to<TAB>for_from<TAB>for_to<NLINE>

in a file with the suffix LANG.sentalign.noncorr,
as usual, in a directory part/doc_id/
'''

import sys

NULL_ALIGN = -1

def get_sentence_offsets(f_in):
    '''
    Return a list of lists containing:
    (sentence_start, sentence_end)
    '''
    offsets = read_file(f_in)
    sentences = []
    current_id = '$'
    for i, (t_start, t_end, t_id, t) in enumerate(offsets):
        # Check if we're at a new sentence
        # I.e. first digits of previous t_id differs from the current
        if current_id[:-3] != t_id[:-3]:
            sentences.append([])
            sentences[-1].append(t_start)
            current_id = t_id

        # Check if the sentence is ending
        # I.e. first digits of next t_id differs from current
        if i == len(offsets)-1 or (i < len(offsets)-1 and offsets[i+1][2][:-3] != t_id[:-3]):
            sentences[-1].append(t_end)

    return sentences

def read_file(f_in):
    '''
    Return a list of tuples containing:
    (token start, token end, token id, token(s))
    '''
    with open(f_in, 'r') as in_f:
        offsets = []
        for line in in_f:
            # This is a workaround since both the .tok.off file
            # and MWEs use a standard white space as delimiters.
            fields = line.split()
            to_add = fields[:3] + [' '.join(fields[3:])]
            offsets.append(to_add)

    return offsets

def map_one_to_one(l1_offsets, l2_offsets):
    '''
    Simple one to one heuristic mapping.
    Returns a list of tuples containing:
    (eng_from, eng_to, for_from, for_to)
    '''

    # Make sure our lists have the same length FIXME: Could be more elegant
    l1_offsets.extend([(NULL_ALIGN, NULL_ALIGN) for _ in range(len(l2_offsets)-len(l1_offsets))])
    l2_offsets.extend([(NULL_ALIGN, NULL_ALIGN) for _ in range(len(l1_offsets)-len(l2_offsets))])

    mapping = []
    for i, l1_offset in enumerate(l1_offsets):
        mapping.append((l1_offset[0], l1_offset[1],
                       l2_offsets[i][0], l2_offsets[i][1]))

    return mapping

def write_alignment(f_out, mapping):
    '''
    Write the alignment info to f_out
    '''
    for l1_from, l1_to, l2_from, l2_to in mapping:
        f_out.write('{}\t{}\t{}\t{}\n'.format(l1_from, l1_to, l2_from, l2_to))

if __name__ == '__main__':
    f_out = sys.stdout
    l1_in = sys.argv[1] # Should be the english file
    l2_in = sys.argv[2] # Should be the foreign file

    l1_sentence_offsets = get_sentence_offsets(l1_in)
    l2_sentence_offsets = get_sentence_offsets(l2_in)

    mapping = map_one_to_one(l1_sentence_offsets, l2_sentence_offsets)
    write_alignment(f_out, mapping)
