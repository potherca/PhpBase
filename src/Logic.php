<?php
namespace Potherca\Base;

/**
 * Base for all Classes that are allowed to contain Logic.
 *
 * A project should have a strict separation between condition (Decision),
 * information (Data) and function (Logic).
 *
 * Extending classes may contain logic which can be applied to data as
 * determined by Decision classes.
 * Extending classes may not, themselves, make Decisions or contain Data.
 *
 * Data should be moved to a class extending the Data class
 * Decisions should be moved to a class extending the Decision class.
 */
abstract class Logic extends Project
{

}
/*EOF*/
