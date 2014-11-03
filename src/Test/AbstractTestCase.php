<?php

namespace Potherca\Base\Test
{
    /**
     * Base Class to be extended by your own Isolated Check classes.
     *
     * The general idea behind this class is to provide an automatic means of
     * enforce a certain set of rules. There is a check for each rule.
     *
     * The Isolated Check class should be declared in the same namespace as the
     * Class it is checking.
     */
    abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
    {
        ////////////////////////////////// FIXTURES \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        const ERROR_COULD_NOT_FIND_CLASS = 'Could not find class';
        const ERROR_INCORRECT_CLASS_SUFFIX = 'Test class name should end in "Test" or "Tests"';
        const ERROR_MAKE_METHODS_PRIVATE = 'The following class methods need to be made abstract, final or private:';
        const ERROR_MAKE_PROPERTIES_PRIVATE = 'The following class properties need to be made private:';
        const ERROR_WILL_NOT_TEST_SELF = 'Skipping test: this class will not test itself';

        /**
         * @expose
         */
        public function tearDown()
        {
            if (class_exists('Mockery', false) === true) {
                /** @noinspection PhpUndefinedClassInspection */
                \Mockery::close();
            }
        }

        /////////////////////////////////// TESTS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        /**
         * @test
         *
         * Class members/properties/fields should always be declared `private`.
         * There really is _no_ reason for an extending class to access the
         * class property directly, it should do so using a getter method.
         *
         * Ideally you should also use setters and getters in the declaring
         * class. Only the setter and getter should have access to the property.
         */
        final public function fieldsShouldBePrivate()
        {
            $sClassName = $this->getNameOfClassUnderTest();

            if (self::class === $sClassName) {
                $this->markTestSkipped(self::ERROR_WILL_NOT_TEST_SELF);
            } else {
                $this->assertClassFieldsArePrivate($sClassName);
            }
        }

        /**
         * @test
         *
         * Class methods should always be declared either `abstract`, `final` or
         * `private`, otherwise they are exposed to being overridden and, thus,
         * break @TODO:add name for law of inheritance
         *
         * Usually, instead of overriding a class method you should be using a
         * decorator patter to manipulate the input/output of such a method or
         * the responsibilities/structure of your class model needs rethinking.
         *
         * If a method _must_ be override-able by a child class it should be
         * marked as `@expose` in the method doc-block.
         */
        final public function methodsShouldBeAbstractOrFinalOrPrivate()
        {
            $sClassName = $this->getNameOfClassUnderTest();
            if (self::class === $sClassName) {
                $this->markTestSkipped(self::ERROR_WILL_NOT_TEST_SELF);
            } else {
                $this->assertClassMethodsAreAbstractOrFinalOrPrivate($sClassName);
            }
        }

        // @TODO: Class should only "use" from the same namespace or lower

        // @TODO: Class should only extend Project class (or derivative)

        //////////////////////////////// ASSERTS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        /**
         * @param string $p_sClassName
         */
        final public function assertClassFieldsArePrivate($p_sClassName)
        {
            $oReflector = $this->getReflectionObjectOfClassUnderTest($p_sClassName);

            $aExposed = $oReflector->getProperties(
                \ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED
            );
            $aPropertyList = $this->buildExposedPropertiesList($aExposed);

            $this->assertCount(0, $aPropertyList, $this->buildExposureMessage(self::ERROR_MAKE_PROPERTIES_PRIVATE , $aPropertyList));
        }

        final public function assertClassMethodsAreAbstractOrFinalOrPrivate($p_sClassName)
        {
            $oReflector = $this->getReflectionObjectOfClassUnderTest($p_sClassName);

            $aReflectionMethods = $oReflector->getMethods();

            $aMethodList = $this->buildExposedMethodsList($aReflectionMethods);

            $this->assertCount(0, $aMethodList, $this->buildExposureMessage(self::ERROR_MAKE_METHODS_PRIVATE,$aMethodList));
        }

        ////////////////////////////// MOCKS AND STUBS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        /**
         * @param string $p_sReturnValue
         * @param string $p_sClassName
         *
         * @return \PHPUnit_Framework_MockObject_MockObject
         */
        final public function getMockStringObject($p_sReturnValue, $p_sClassName = '\stdClass')
        {
            return $this->getMockBuilder('\stdClass')
                ->setMockClassName((string) $p_sClassName)
                ->getMock()
                ->expects($this->atLeastOnce())
                ->method('__toString')
                ->willReturn((string) $p_sReturnValue)
            ;
        }

        /////////////////////////////// DATAPROVIDERS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

        ////////////////////////////// UTILITY METHODS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        /**
         * @return string
         */
        private function getNameOfClassUnderTest()
        {
            $sClassName = '';

            $sTestClassName = get_called_class();
            if (substr($sTestClassName, -4) === 'Test') {
                $sClassName = substr($sTestClassName, 0, -4);
            } elseif (substr($sTestClassName, -5) === 'Tests') {
                $sClassName = substr($sTestClassName, 0, -5);
            } else {
                $this->fail(self::ERROR_INCORRECT_CLASS_SUFFIX);
            }

            return $sClassName;
        }

        /**
         * @param string $p_sClassName
         *
         * @return \ReflectionClass
         */
        private function getReflectionObjectOfClassUnderTest($p_sClassName)
        {
            try {
                $reflector = new \ReflectionClass($p_sClassName);
            } catch (\ReflectionException $ex) {
                throw new \PHPUnit_Framework_AssertionFailedError(
                    sprintf(self::ERROR_COULD_NOT_FIND_CLASS . ' "%s"', $p_sClassName)
                );
            }

            return $reflector;
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

        /**
         * @param \ReflectionProperty[]  $p_aExposedProperties
         *
         * @return string[]
         */
        private function buildExposedPropertiesList(array $p_aExposedProperties)
        {
            $aPropertyList = array();

            array_walk(
                $p_aExposedProperties,
                function (\ReflectionProperty $p_oReflectionProperty) use (&$aPropertyList) {
                    $sPropertyName = ' - '
                        . $p_oReflectionProperty->getDeclaringClass()->getName()
                        . ' -> '
                        . $p_oReflectionProperty->getName()
                        . ' ('
                        . ($p_oReflectionProperty->isPublic()
                            ? 'public'
                            : 'protected')
                        . ($p_oReflectionProperty->isStatic()
                            ? ' static'
                            : '')
                        . ')'
                    ;

                    array_push($aPropertyList, $sPropertyName);
                }
            );

            return $aPropertyList;
        }

        /**
         * @param \ReflectionMethod[] $p_aReflectionMethods
         *
         * @return string[]
         */
        private function buildExposedMethodsList(array $p_aReflectionMethods)
        {
            $aMethodList = array();

            array_walk(
                $p_aReflectionMethods,
                function (\ReflectionMethod $p_oReflectionMethod) use (&$aMethodList) {

                    $sDocComment = $p_oReflectionMethod->getDocComment();
                    $bExposureAllowed = (bool) strpos($sDocComment, '@expose');

                    if($bExposureAllowed === false
                        && (
                            $p_oReflectionMethod->isProtected()
                            || (
                                $p_oReflectionMethod->isPublic()
                                && $p_oReflectionMethod->isAbstract() === false
                                && $p_oReflectionMethod->isFinal() === false
                            )
                        )
                    ){
                        $sMethodName = ' - '
                            . $p_oReflectionMethod->getDeclaringClass()->getName()
                            . ' -> '
                            . $p_oReflectionMethod->getName()
                            . ' ('
                            . ($p_oReflectionMethod->isPublic()
                                ? 'public'
                                : 'protected')
                            . ')'
                        ;

                        array_push($aMethodList, $sMethodName);
                    }
                }
            );

            return $aMethodList;
        }
    }
}

/*EOF*/
