:- module(parse2boxer, [
    main/0]).

:- use_module(slashes).
:- use_module(util, [
    argv/1,
    substitute_sub_term/3,
    term_in_file/3,
    write_clause/1]).

main :-
  argv([ParseFile]),
  forall(
      ( term_in_file(Term0, ParseFile, [module(slashes)])
      ),
      ( substitute_sub_term(translate, Term0, Term),
	write_clause(Term)
      ) ),	
  halt(0).
main :-
  format(user_error, 'USAGE: swipl -l parse2xml.pl -g main PARSEFILE > XMLFILE~n', []),
  halt(1).

translate(ccg(N, D0), der(N, D)) :-
  !,
  substitute_sub_term(translate, D0, D).
translate(ba(Cat, D10, D20), ba(Cat, nil, D1, D2)) :-
  !,
  substitute_sub_term(translate, D10, D1),
  substitute_sub_term(translate, D20, D2).
translate(fa(Cat, D10, D20), fa(Cat, nil, D1, D2)) :-
  !,
  substitute_sub_term(translate, D10, D1),
  substitute_sub_term(translate, D20, D2).
translate(bc(Cat, D10, D20), bc(Cat, nil, D1, D2)) :-
  !,
  substitute_sub_term(translate, D10, D1),
  substitute_sub_term(translate, D20, D2).
translate(fc(Cat, D10, D20), fc(Cat, nil, D1, D2)) :-
  !,
  substitute_sub_term(translate, D10, D1),
  substitute_sub_term(translate, D20, D2).
translate(bxc(Cat, D10, D20), bxc(Cat, nil, D1, D2)) :-
  !,
  substitute_sub_term(translate, D10, D1),
  substitute_sub_term(translate, D20, D2).
translate(fxc(Cat, D10, D20), fxc(Cat, nil, D1, D2)) :-
  !,
  substitute_sub_term(translate, D10, D1),
  substitute_sub_term(translate, D20, D2).
translate(conj(Cat, D10, D20), conj(Cat, nil, D1, D2)) :-
  !,
  substitute_sub_term(translate, D10, D1),
  substitute_sub_term(translate, D20, D2).
translate(lx(X/(X\Y), Y, Der0), ftr(X/(X\Y), Y, nil, Der)) :-
  !,
  substitute_sub_term(translate, Der0, Der).
translate(lx(X\(X/Y), Y, Der0), btr(X\(X/Y), Y, nil, Der)) :-
  !,
  substitute_sub_term(translate, Der0, Der).
translate(lx(NewCat, OldCat, Der0), tc(NewCat, OldCat, nil, Der)) :-
  !,
  substitute_sub_term(translate, Der0, Der).
translate(lp(Cat, t(_, Token, Atts), D20), fa(Cat, nil, t(Cat/Cat, nil, Token, Atts), D2)) :-
  !,
  substitute_sub_term(translate, D20, D2).
translate(rp(Cat, D10, t(_, Token, Atts)), ba(Cat, nil, D1, t(Cat\Cat, nil, Token, Atts))) :-
  !,
  substitute_sub_term(translate, D10, D1).
translate(t(Cat, Token, Atts), t(nil, Cat, Token, Atts)).
