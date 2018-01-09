:- module(catobj, [
    co_cat/2,
    functor_in/2]).

:- use_module(slashes).

% Utilities for working with category objects.

functor_in(CO, CO).
functor_in(CO, X/_) :-
  functor_in(CO, X).
functor_in(CO, X\_) :-
  functor_in(CO, X).
functor_in(CO, X-_) :-
  functor_in(CO, X).

co_cat(co(_, Cat), Cat) :-
  !.
co_cat(X/Y, XCat/YCat) :-
  co_cat(X, XCat),
  co_cat(Y, YCat).
co_cat(X\Y, XCat\YCat) :-
  co_cat(X, XCat),
  co_cat(Y, YCat).
