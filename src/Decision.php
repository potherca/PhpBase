<?php
namespace Potherca\Base;

/**
 * Base for all Classes that are allowed to make a Decision.
 *
 * A project should have a strict separation between condition (Decision),
 * information (Data) and function (Logic).
 *
 * Extending classes may make a Decision about which Logic should be applied to
 * which Data.
 * Extending classes may not, themselves, contain Data or Logic.
 *
 * Data should be moved to a class extending the Data class
 * Logic should be moved to a class extending the Logic class
 */
abstract class Decision extends Project
{

}
/*EOF*/
