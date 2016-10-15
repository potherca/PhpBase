# PHP Base - Base for all classes in Potherca Projects

[![Project Stage Badge: Experimental]][Project Stage Page]
[![Build Status Badge]][Travis-CI Page]
[![Coverage Status Badge]][Coveralls Page]
[![License Badge]][GPL3+]


## General Concept

This repository contains some classes that are needed for an experiment one
of my projects is currently involved in.

This experiment consists of three separate concepts

1. There should *only* be **one** single point where objects are created
2. Classes in a project should *only* extend a 'base' class
3. Any class should *only* contain Data, Logic *or* Decisions.

Yes, I know *madness*. No, I don't expect you do take this seriously or follow
my lead. It's just to satisfy my own curiosity. That is why it is called an
"experiment".

## Broader Explanation

### Single point of creation

Just as a class method should only contain one single return statement, or a
project should only contain *one* single `echo` statement (these are from other
experiments I did a while ago), there should only be **one** single point where
objects are created. This should either be a single delivery mechanism file,
(like the well-known `index.php`), a factory, or a "service locator".

The locator is a last resort and only acceptable as long as the locator is kept
out of the rest of the project. The service locator pattern really *is* an
anti-pattern as far as it makes *everything* in your project *very* tightly
coupled to anything the locator might contain (even is it is just semantically).

### Very strict parents indeed

All classes in this experiment should extend the `Project` class or a class
that extends that class. This way there is absolutely _no_ chance of any vendor
or native PHP classes being extended.

This allows us to add a check to the build to enforce the [Composition over
Inheritance] "rule".

The `Project` class itself explicitly extends the native PHP class, to make sure
there is no cheating this rule.

### Do as I say

Classes should also have a strict separation between condition (Decision),
information (Data) and function (Logic). To enforce this there are three (empty)
abstract classes for project classes to extend. These classes make it explicitly
clear what they expect child classes to contain.

Data should be moved to a class extending the `Data` class
Decisions should be moved to a class extending the `Decision` class.
Logic should be moved to a class extending the `Logic` class.

When a class has method(s) that break this rule, offending functions should be
moved to another class that is a better fit. If such a class does not exist it
will have to be written.

#### Logic Class

Extending classes may contain logic which can be applied to data as
determined by Decision classes.
Extending classes may not, themselves, make Decisions or contain Data.

#### Data Class
Extending classes may contain data that can be passed to Logic classes as
determined by Decision classes.
Extending classes may not, themselves, make Decisions or contain Logic.

#### Decision Class
Extending classes may make a Decision about which Logic should be applied to
which Data.
Extending classes may not, themselves, contain Data or Logic.

---

0.1.1 – The Source Code for this project is available on github.com under a
[GPLv3 License][GPL3+] – Created by [Potherca]


[Composition over Inheritance]: http://c2.com/cgi/wiki?CompositionInsteadOfInheritance

[GPL3+]: ./LICENSE
[Potherca]: http://pother.ca/

[Build Status Badge]: https://travis-ci.org/potherca/PhpBase.svg
[Coverage Status Badge]: https://img.shields.io/coveralls/potherca/PhpBase.svg
[License Badge]: https://img.shields.io/badge/License-GPL3%2B-lightgray.svg
[Project Stage Badge: Experimental]: http://img.shields.io/badge/Project%20Stage-Experimental-yellow.svg

[Coveralls Page]: https://coveralls.io/r/potherca/PhpBase
[Project Stage Page]: http://bl.ocks.org/potherca/a2ae67caa3863a299ba0
[Travis-CI Page]: https://travis-ci.org/Potherca/PhpBase
