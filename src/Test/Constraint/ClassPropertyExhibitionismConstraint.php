<?php
namespace Potherca\Base\Test\Constraint;

class ClassPropertyExhibitionismConstraint extends AbstractClassExhibitionismConstraint
{
    const ERROR_MAKE_PROPERTIES_PRIVATE = 'The following class properties need to be made private:';
    /**
     * @return string
     */
    final public function getExposureMessage()
    {
        return self::ERROR_MAKE_PROPERTIES_PRIVATE;
    }

    /**
     * @param \ReflectionClass $p_oReflector
     *
     * @return \Reflector[]
     */
    final public function retrieveExposedReflectors(\ReflectionClass $p_oReflector)
    {
        $aExposedReflectors = $p_oReflector->getProperties(
            \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED
        );

        return $aExposedReflectors;
    }

    /**
     * @return callable
     */
    public function getExposureValidator()
    {
        return null;
    }
}
