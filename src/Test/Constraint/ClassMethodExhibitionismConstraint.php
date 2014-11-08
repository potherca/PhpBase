<?php
namespace Potherca\Base\Test\Constraint;

class ClassMethodExhibitionismConstraint extends AbstractClassExhibitionismConstraint
{
    const ERROR_MAKE_METHODS_PRIVATE = 'The following class methods need to be made abstract, final or private:';

    /**
     * @return string
     */
    final public function getExposureMessage()
    {
        return self::ERROR_MAKE_METHODS_PRIVATE;
    }
    /**
     * @param \ReflectionClass $p_oReflector
     *
     * @return \ReflectionMethod[]
     */
    final public function retrieveExposedReflectors(\ReflectionClass $p_oReflector)
    {
        return $p_oReflector->getMethods();
    }

    /**
     * @return callable
     */
    public function getExposureValidator()
    {
        return function (\ReflectionMethod $p_oReflector) {
            $bExposureAllowed = false;

            $sDocComment = $p_oReflector->getDocComment();
            $bExposureTagPresent = (bool) strpos($sDocComment, \Potherca\Base\Test\EXPOSURE_TAG);

            //@TODO: Validate a reason for exclusion has also been given when annotation is present

            if ($bExposureTagPresent === true
                || $p_oReflector->isPrivate()
                || ($p_oReflector->isPublic() && $p_oReflector->isFinal())
                || $p_oReflector->isAbstract() === true
            ) {
                $bExposureAllowed = true;
            }
            return $bExposureAllowed;
        };

    }
}
