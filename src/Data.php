<?php
namespace Potherca\Base;

/**
 * Base for all Classes that are allowed to contain Data.
 *
 * A project should have a strict separation between condition (Decision),
 * information (Data) and function (Logic).
 *
 * Extending classes may contain data that can be passed to Logic classes as
 * determined by Decision classes.
 * Extending classes may not, themselves, make Decisions or contain Logic.
 *
 * Decisions should be moved to a class extending the Decision class.
 * Logic should be moved to a class extending the Logic class.
 */
abstract class Data extends Project
{

}
/*EOF*/
