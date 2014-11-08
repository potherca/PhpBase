<?php

namespace Potherca\Base\Test\Constraint;

abstract class AbstractClassExhibitionismConstraint extends \PHPUnit_Framework_Constraint
{
    ////////////////////////////// CLASS PROPERTIES \\\\\\\\\\\\\\\\\\\\\\\\\\\\
    /** @var  array */
    private $m_aExposureList;

    //////////////////////////// SETTERS AND GETTERS \\\\\\\\\\\\\\\\\\\\\\\\\\\

    /**
     * @return string
     */
    abstract public function getExposureMessage();

    /**
     * @return callable
     */
    abstract public function getExposureValidator();

    /**
     * @return array
     */
    private function getExposureList()
    {
        return $this->m_aExposureList;
    }

    /**
     * @param array $p_aExposureList
     */
    private function setExposureList(array $p_aExposureList)
    {
        $this->m_aExposureList = $p_aExposureList;
    }

    //////////////////////////////// PUBLIC API \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    /**
     * @param \ReflectionClass $p_oReflector
     *
     * @return \Reflector[]
     */
    abstract public function retrieveExposedReflectors(\ReflectionClass $p_oReflector);

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    final public function toString()
    {
        return ' hasn\'t exposed itself';
    }

    ////////////////////////////// UTILITY METHODS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param  string $p_sClassName Value or object to evaluate.
     *
     * @return bool
     */
    final protected function matches($p_sClassName)
    {
        $oReflector = new \ReflectionClass($p_sClassName);

        $aExposedReflectors = $this->retrieveExposedReflectors($oReflector);
        $aExposureList = $this->buildExposuresList($aExposedReflectors);

        $this->setExposureList($aExposureList);

        return(count($this->m_aExposureList) === 0);
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param  string $p_sClassUnderTest
     *
     * @return string
     */
    final protected function failureDescription($p_sClassUnderTest)
    {
        return 'class ' . $p_sClassUnderTest . $this->toString();
    }

    /**
     * Return additional failure description where needed
     *
     * The function can be overridden to provide additional failure
     * information like a diff
     *
     * @param  mixed  $other Evaluated value or object.
     * @return string
     */
    final protected function additionalFailureDescription($other)
    {
        return $this->buildExposureMessage($this->getExposureMessage(), $this->getExposureList());
    }

    /**
     * @param \ReflectionMethod[]|\ReflectionProperty[] $p_aReflectors
     *
     * @return string[]
     */
    private function buildExposuresList(array $p_aReflectors)
    {
        $aMethodList = array();

        foreach ($p_aReflectors as $p_oReflector) {
            $cExposureValidator = $this->getExposureValidator();
            if ($cExposureValidator === null || $cExposureValidator($p_oReflector) === false) {
                $sPropertyName = $this->reflectorDescription($p_oReflector);
                array_push($aMethodList, $sPropertyName);
            }
        }

        return $aMethodList;
    }

    /**
     * @param \ReflectionMethod|\ReflectionProperty|\Reflector $p_oReflector
     *
     * @return string
     */
    private function reflectorDescription(\Reflector $p_oReflector)
    {
        $sDescription = ' - '
            . $p_oReflector->getDeclaringClass()->getName()
            . ' -> '
            . $p_oReflector->getName()
            . ' ('
            . ($p_oReflector->isPublic()
                ? 'public'
                : 'protected')
            . ($p_oReflector->isStatic()
                ? ' static'
                : '')
            . ')';

        return $sDescription;
    }

    /**
     * @param string $p_sFormat
     * @param string[] $p_aList
     *
     * @return string
     */
    private function buildExposureMessage($p_sFormat, $p_aList)
    {
        return  sprintf($p_sFormat . PHP_EOL . '%s', implode(PHP_EOL, $p_aList));
    }
}
