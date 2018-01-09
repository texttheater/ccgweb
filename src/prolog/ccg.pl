:- module(ccg, [
    ccg_cat/2,
    ccg_pp/2,
    const_in_ccg/2,
    node2ccg/2]).

:- use_module(catobj, [
    co_cat/2]).
:- use_module(der, [
    node_co/2]).
:- use_module(slashes).
:- use_module(util, [
    times/2,
    write_atom_quoted/1]).

node2ccg(Node, CCG) :-
  node2ccg_(Node, CCG),
  node_co(Node, CO),
  co_cat(CO, Cat),
  ccg_cat(CCG, Cat).

node2ccg_(node(_, _, comp(0, f, h), [Node1, Node2]), fa(X, Der1, Der2)) :-
  node2ccg_(Node1, Der1),
  ccg_cat(Der1, X/Y),
  node2ccg_(Node2, Der2),
  ccg_cat(Der2, Y),
  node_co(Node2, CO2),
  co_cat(CO2, Y).
node2ccg_(node(_, _, comp(0, b, h), [Node2, Node1]), ba(X, Der2, Der1)) :-
  node2ccg_(Node2, Der2),
  ccg_cat(Der2, Y),
  node2ccg_(Node1, Der1),
  ccg_cat(Der1, X\Y),
  node_co(Node2, CO2),
  co_cat(CO2, Y).
node2ccg_(node(_, _, comp(1, f, h), [Node1, Node2]), fc(X/Z, Der1, Der2)) :-
  node2ccg_(Node1, Der1),
  ccg_cat(Der1, X/Y),
  node2ccg_(Node2, Der2),
  ccg_cat(Der2, Y/Z),
  node_co(Node2, CO2/_),
  co_cat(CO2, Y).
node2ccg_(node(_, _, comp(1, f, x), [Node1, Node2]), fxc(X\Z, Der1, Der2)) :-
  node2ccg_(Node1, Der1),
  ccg_cat(Der1, X/Y),
  node2ccg_(Node2, Der2),
  ccg_cat(Der2, Y\Z),
  node_co(Node2, CO2\_),
  co_cat(CO2, Y).
node2ccg_(node(_, _, comp(1, b, h), [Node2, Node1]), bc(X\Z, Der2, Der1)) :-
  node2ccg_(Node2, Der2),
  ccg_cat(Der2, Y\Z),
  node2ccg_(Node1, Der1),
  ccg_cat(Der1, X\Y),
  node_co(Node2, CO2\_),
  co_cat(CO2, Y).
node2ccg_(node(_, _, comp(1, b, x), [Node2, Node1]), bxc(X/Z, Der2, Der1)) :-
  node2ccg_(Node2, Der2),
  ccg_cat(Der2, Y/Z),
  node2ccg_(Node1, Der1),
  ccg_cat(Der1, X\Y),
  node_co(Node2, CO2/_),
  co_cat(CO2, Y).
node2ccg_(node(_, _, ftr, [ONode]), tr(Y/(Y\X), ODer)) :-
  node2ccg_(ONode, ODer),
  ccg_cat(ODer, X).
node2ccg_(node(_, _, btr, [ONode]), tr(Y\(Y/X), ODer)) :-
  node2ccg_(ONode, ODer),
  ccg_cat(ODer, X).
node2ccg_(node(_, _, tc(_), [ONode]), lx(_, Y, ODer)) :-
  node2ccg_(ONode, ODer),
  ccg_cat(ODer, Y),
  node_co(ONode, OCO),
  co_cat(OCO, Y).
% TODO other rules
node2ccg_(node(_, _, t(Form, Atts), []), t(_, Form, Atts)) :-
  member(sem:_, Atts),
  !.
% Lexical nodes that are the result of category merging don't have a semantic
% tag, so we include the lambda-DRS explicitly:
node2ccg_(node(_, Sem, t(Form, Atts), []), t(_, Form, [lam:Sem|Atts])).

ccg_cat(CCG, Cat) :-
  arg(1, CCG, Cat).

const_in_ccg(CCG, CCG).
const_in_ccg(Const, fa(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, fa(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, ba(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, ba(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, fc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, fc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, bc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, bc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, fxc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, fxc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, bxc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, bxc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gfc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gfc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gbc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gbc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gfxc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gfxc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gbxc(_, D, _)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, gbxc(_, _, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, tr(_, D)) :-
  const_in_ccg(Const, D).
const_in_ccg(Const, lx(_, _, D)) :-
  const_in_ccg(Const, D).

ccg_pp(ccg(ID, Der)) :-
  write('ccg('),
  write(ID),
  write(','),
  nl,
  ccg_pp(1, Der),
  write(').'),
  nl.

ccg_pp(Level, t(Cat, Form, Tags)) :-
  !,
  times(write(' '), Level),
  write('t('),
  write_term(Cat, [module(slashes)]),
  write(', '),
  write_atom_quoted(Form),
  write(', ['),
  forall(
      ( member(Type:Tag, Tags)
      ),
      ( write(Type),
        write(':'),
        write_atom_quoted(Tag)
      ) ),
  write('])').
ccg_pp(Level, lx(NewCat, OldCat, Daughter)) :-
  !,
  times(write(' '), Level),
  write('lx('),
  write_term(NewCat, [module(slashes)]),
  write(', '),
  write_term(OldCat, [module(slashes)]),
  write(','),
  nl,
  NewLevel is Level + 1,
  ccg_pp(NewLevel, Daughter),
  write(')').
ccg_pp(Level, Der) :-
  times(write(' '), Level),
  Der =.. [Rule, Cat, D1, D2],
  write(Rule),
  write('('),
  write_term(Cat, [module(slashes)]),
  write(','),
  nl,
  NewLevel is Level + 1,
  ccg_pp(NewLevel, D1),
  write(','),
  nl,
  ccg_pp(NewLevel, D2),
  write(')').
