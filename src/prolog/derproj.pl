:- module(derproj, [
    main/0]).

:- use_module(catobj, [
    functor_in/2]).
:- use_module(ccg, [
    node2ccg/2]).
:- use_module(der, [
    der2node/2]).
:- use_module(slashes).
:- use_module(sr, [
    parse/2]).
:- use_module(tokoff, [
    tokoff_read_file/2]).
:- use_module(util, [
    argv/1,
    enumerate/2,
    split/4,
    substitute_sub_term/4,
    term_in_file/2,
    write_clause/1,
    write_clause/3]).

:- dynamic source_sentence_catobj/3.
:- dynamic source_catobj/5. % TODO refactor to source_node/3?
:- dynamic source_typechanger/3.
:- dynamic wordalign/3.
:- dynamic sentalign/4.
:- dynamic target_catobj/5. % TODO refactor to target_node/3?
:- dynamic target_typechanger/3.

main :-
  argv([EnglishDerFile, WordAlignFile, SentAlignFile, ForeignTokOffFile, EnglishTokOffFile]),
  % Load information from various sources:
  load_source_derivations(EnglishDerFile),
  %with_output_to(user_error, listing(source_catobj/5)),
  load_wordalign_file(WordAlignFile),
  load_sentalign_file(SentAlignFile),
  tokoff_read_file(ForeignTokOffFile, ForeignSentences),
  tokoff_read_file(EnglishTokOffFile, EnglishSentences),
  % Project:
  transfer_categories(ForeignSentences, EnglishSentences),
  transfer_typechangers,
  flip_slashes,
  parse(ForeignSentences),
  halt.
main :-
  format(user_error, 'USAGE (example): swipl -l derproj -g main en.der nl.wordalign nl.tok.off en.tok.off~n', []),
  halt(1).

%%% CORE PROJECTION PREDICATES %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% Asserts target_catobj/5 facts mapping target tokens to category objects.
transfer_categories(ForeignSentences, EnglishSentences) :-
  forall(
      ( member(Sentence, ForeignSentences),
        member(tokoff(ForFrom, ForTo, _TokID, Token), Sentence)
      ),
      ( findall(EngFrom-EngTo,
            ( wordalign(ForFrom, ForTo, EnglishOffsets),
              member(EngFrom-EngTo, EnglishOffsets)
            ), Pairs),
        (  Pairs = []
        -> format(user_error, 'nothing aligned to token "~w" (~w, ~w), skipping~n', [Token, ForFrom, ForTo])
        ;  Pairs = [_, _|_]
        -> findall(EngTokoff,
               ( member(EngFrom-EngTo, Pairs),
                 once(
                     ( member(EnglishSentence, EnglishSentences),
                       member(EngTokoff, EnglishSentence),
                       EngTokoff = tokoff(EngFrom, EngTo, _, _)
                     ) )
               ), EngPhrase),
           make_item(source_catobj, source_typechanger, EngPhrase, Item),
           parse([Item], Parses),
           (  Parses = []
           -> format(user_error, 'no parse for phrase aligned to token "~w" (~w, ~w), skipping~n', [Token, ForFrom, ForTo])
           ;  Parses = [_, _|_]
           -> format(user_error, 'WARNING: ambiguous phrase aligned to token "~w" (~w, ~w), skipping~n', [Token, ForFrom, ForTo])
           ;  Parses = [item([node(CO, Sem0, _, _)], [], _, true)]
           -> replace_indices(ForFrom, ForTo, Sem0, Sem),
              assertz(target_catobj(ForFrom, ForTo, CO, Sem, [from:ForFrom, to:ForTo]))
           )
        ;  Pairs = [EngFrom-EngTo],
           source_catobj(EngFrom, EngTo, CO, Sem0, Atts)
        -> replace_indices(ForFrom, ForTo, Sem0, Sem),
           assertz(target_catobj(ForFrom, ForTo, CO, Sem, [from:ForFrom, to:ForTo|Atts]))
        ;  format(user_error, 'token "~w" (~w, ~w) one-to-one aligned but no category object found, skipping~n', [Token, ForFrom, ForTo])
        )
      ) ).

% Asserts target_typechanger/3 facts mapping target tokens to typechangers. This
% overgenerates a bit as we need each typechanger only once per sentence.
transfer_typechangers :-
  forall(
      ( source_typechanger(TCFrom, TCTo, TC),
        wordalign(ForFrom, ForTo, EngOffsets),
        member(EngFrom-EngTo, EngOffsets),
        target_catobj(ForFrom, ForTo, _, _, _),
        EngFrom >= TCFrom,
        EngTo =< TCTo
      ),
      ( % associate the type changer with possible target tokens
        assertz(target_typechanger(ForFrom, ForTo, TC))
      ) ).

flip_slashes :-
  forall(
      ( clause(target_catobj(From, To, CO, Sem, Atts), true, Ref)
      ),
      ( (  flip_slashes(CO, From, To, FlipCO)
        -> erase(Ref),
           assertz(target_catobj(From, To, FlipCO, Sem, Atts))
        ;  true % TODO Do something more intelligent? Warn?
        )
      ) ).

flip_slashes(X/Y, From, To, FlipCO) :-
  flip_slashes(X, Y, From, To, FlipCO).
flip_slashes(X\Y, From, To, FlipCO) :-
  flip_slashes(X, Y, From, To, FlipCO).
flip_slashes(co(ID, Cat), _, _, co(ID, Cat)).

flip_slashes(X, Y, XFrom, XTo, FlipX/Y) :-
  flip_slashes(X, XFrom, XTo, FlipX),
  functor_from_to(Y, YFrom, _),
  YFrom > XTo.
flip_slashes(X, Y, XFrom, XTo, FlipX\Y) :-
  flip_slashes(X, XFrom, XTo, FlipX),
  functor_from_to(Y, _, YTo),
  YTo < XFrom.

parse(ForeignSentences) :-
  forall(
      ( enumerate(I, member(ForeignSentence, ForeignSentences))
      ),
      ( % Determine target category object based on sentence alignments:
        sentence_from_to(ForeignSentence, ForFrom, ForTo),
        (  findall(EngFrom-EngTo, sentalign(EngFrom, EngTo, ForFrom, ForTo), [EngFrom-EngTo]),
           source_sentence_catobj(EngFrom, EngTo, TargetCO)
        -> true
        ;  format(user_error, 'WARNING: no target category object for sentence ~w found (did not find or failed to analyze 1:1 aligned source sentence)~n', [I]),
           TargetCO = dummy
        ),
        % Parse the foreign sentence using projected categories:
        make_item(target_catobj, target_typechanger, ForeignSentence, Item),
        catch(
            ( parse([Item], Agenda0)
            ), agenda_limit_exceeded,
            ( format(user_error, 'WARNING: parser agenda limit exceeded~n', []),
              Agenda0 = []
            ) ),
        include(hits_target(TargetCO), Agenda0, Agenda),
        length(Agenda, Length),
        (  Length = 0
        -> format(user_error, 'WARNING: no parse projected for sentence ~w~n', [I])
        ;  (  Length > 1
           -> format(user_error, 'WARNING: ~w different parses projected for sentence ~w~n', [Length, I])
           ;  true
           ),
           Agenda = [item([Node], [], _, true)|_],
           node2ccg(Node, CCG),
           write_clause(current_output, ccg(I, CCG), [module(slashes)])
        )
      ) ).

%%% LOADERS %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% Asserts source_catobj/5 and source_typechanger/3 facts mapping source offset
% pairs to lexical category objects and to typechangers.
load_source_derivations(EnglishDerFile) :-
  forall(
      ( term_in_file(der(ID, Der), EnglishDerFile)
      ),
      (  der2node(Der, Node)
      -> % Get lexical category objects:
         forall(
             ( sub_node(node(CO, Sem, t(_Form, Atts0), []), Node),
               select(from:From, Atts0, Atts1),
               select(to:To, Atts1, Atts)
             ),
             ( assertz(source_catobj(From, To, CO, Sem, Atts))
             ) ),
         % Get type changers:
         forall(
             ( sub_node(node(X, _, tc(TCSem), [Child]), Node),
               Child = node(Y, _, _, _)
             ),
             ( node_from_to(Child, From, To),
               assertz(source_typechanger(From, To, tc(X-Y, TCSem)))
             ) ),
         % Get sentence category object:
         node_from_to(Node, From, To),
         Node = node(CO, _, _, _),
         assertz(source_sentence_catobj(From, To, CO))
      ;  format(user_error, 'WARNING: failed to analyze English derivation ~w for category projection~n', [ID])
      ) ).

% Reads the word alignment file and asserts its contents as wordalign/3 facts.
load_wordalign_file(WordAlignFile) :-
  csv_read_file(WordAlignFile, WordAlignRows, [separator(9)]),
  findall(wordalign(ForeignFrom, ForeignTo, EnglishOffsetsList),
      ( member(row(ForeignFrom, ForeignTo, EnglishOffsetsAtom), WordAlignRows),
        atom_codes(EnglishOffsetsAtom, EnglishOffsetsCodes),
        split(EnglishOffsetsCodes, 32, infinity, PairCodess),
        findall(EnglishFrom-EnglishTo,
            ( member(PairCodes, PairCodess),
              split(PairCodes, 44, infinity, [EnglishFromCodes, EnglishToCodes]),
              number_codes(EnglishFrom, EnglishFromCodes),
              number_codes(EnglishTo, EnglishToCodes)
            ), EnglishOffsetsList)
      ), WordAlignTerms),
  maplist(assertz, WordAlignTerms).

% Reads the sentence alignment file and asserts its contents as sentalign/4 facts.
load_sentalign_file(SentAlignFile) :-
  csv_read_file(SentAlignFile, SentAlignRows, [separator(9), functor(sentalign)]),
  maplist(assertz, SentAlignRows).

%%% HELPERS %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

hits_target(TargetCO, item([node(TargetCO, _, _, _)], _, _, _)).

functor_from_to(Functor, From, To) :-
  target_catobj(From, To, CO, _, _),
  functor_in(Functor, CO).
functor_from_to(Functor, From, To) :-
  target_typechanger(From, To, tc(CO, _)),
  functor_in(Functor, CO).

% With target_catobj/5 (source_catobj/5) and target_typechanger/3
% (source_typechanger/3) facts asserted, creates the initial shift-reduce
% parser item for the target sentence.
make_item(_, _, [], item([], [], [], false)).
make_item(COPred, TCPred, [tokoff(From, To, _TokID, Token)|Sent], item([], [Choices|Queue], TypeChangers, false)) :-
  % Recursively generate the initial item for the rest of the sentence:
  make_item(COPred, TCPred, Sent, item([], Queue, TypeChangers0, false)),
  findall(node(CO, Sem, t(Token, Atts), []), call(COPred, From, To, CO, Sem, Atts), Choices),
  findall(TC,
      ( call(TCPred, From, To, TC),
        \+ member(TC, TypeChangers0)
      ), NewTypeChangers),
  append(NewTypeChangers, TypeChangers0, TypeChangers).

sub_node(Node, Node).
sub_node(Sub, node(_, _, _, Children)) :-
  member(Child, Children),
  sub_node(Sub, Child).

node_from_to(node(_, _, t(_, Atts), []), From, To) :-
  !,
  member(from:From, Atts),
  member(to:To, Atts).
node_from_to(node(_, _, _, Children), From, To) :-
  Children = [First|_],
  node_from_to(First, From, _),
  last(Children, Last),
  node_from_to(Last, _, To).

sentence_from_to(Sentence, From, To) :-
  Sentence = [tokoff(From, _, _, _)|_],
  last(Sentence, tokoff(_, To, _, _)).

replace_indices(ForFrom, ForTo, Sem0, Sem) :-
  substitute_sub_term(P:[_|_]:C, P:[ForFrom, ForTo]:C, Sem0, Sem).