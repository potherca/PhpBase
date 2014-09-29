<?php

namespace Potherca\Base;

/**
 * Base for all classes in Potherca Projects
 *
 * All classes in any Potherca project should extend this class or a class that
 * extends this class. That way there is absolutely _no_ chance of any vendor or
 * native PHP classes being extended. This allows us to add a check to the build
 * to enforce the "Composition over Inheritance" rule
 */
abstract class Project extends \stdClass
{

}
