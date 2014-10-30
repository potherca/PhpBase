<?php

namespace Potherca\Base\Test
{
    /**
     * @coversDefaultClass Potherca\Base\Test\AbstractTestCase
     * @covers ::<!public>
     * @covers ::tearDown
     */
    class AbstractTestCaseTest extends AbstractTestCase
    {
        ////////////////////////////////// FIXTURES \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        const ERROR_EXCEPTION_NOT_THROWN = 'Failed asserting that exception of type "\PHPUnit_Framework_AssertionFailedError" is thrown.';

        /////////////////////////////////// TESTS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        /**
         * @test
         *
         * @covers ::fieldsShouldBePrivate
         */
        final public function abstractTestCaseShouldRefuseToTestItselfWhenPrivateFieldTestIsCalled()
        {
            try {
                parent::fieldsShouldBePrivate();
            } catch (\PHPUnit_Framework_SkippedTestError $eSkipped) {
                $this->assertEquals(self::ERROR_WILL_NOT_TEST_SELF, $eSkipped->getMessage());
            }
        }

        /**
         * @test
         * @covers ::methodsShouldBeAbstractOrFinalOrPrivate
         */
        final public function abstractTestCaseShouldRefuseToTestItselfWhenMethodsExposureTestIsCalled()
        {
            try {
                parent::methodsShouldBeAbstractOrFinalOrPrivate();
            } catch (\PHPUnit_Framework_SkippedTestError $eSkipped) {
                $this->assertEquals(self::ERROR_WILL_NOT_TEST_SELF, $eSkipped->getMessage());
            }
        }

        /**
         * @test
         *
         * @covers ::assertClassFieldsArePrivate
         *
         * @dataProvider provideExposedPropertiesList
         *
         * @param $p_sExpected
         */
        final public function abstractTestCaseShouldProtestWhenClassContainsExposedProperties($p_sExpected) {
            try {
                $sClassName = AbstractTestCase::class;
                parent::assertClassFieldsArePrivate($sClassName);
                $this->fail(self::ERROR_EXCEPTION_NOT_THROWN);
            } catch (\PHPUnit_Framework_AssertionFailedError $eFail) {
                if ($eFail->getMessage() === self::ERROR_EXCEPTION_NOT_THROWN) {
                    throw $eFail;
                } else {
                    $this->assertEquals($p_sExpected, $eFail->getMessage());
                }
            }
        }

        /**
         * @test
         *
         * @covers ::assertClassMethodsAreAbstractOrFinalOrPrivate
         *
         * @dataProvider provideExposedMethodsList
         *
         * @param $p_sExpected
         */
        final public function abstractTestCaseShouldProtestWhenClassContainsExposedMethods($p_sExpected) {
            try {
                $sClassName = AbstractTestCase::class;
                parent::assertClassMethodsAreAbstractOrFinalOrPrivate($sClassName);
                $this->fail(self::ERROR_EXCEPTION_NOT_THROWN);
            } catch (\PHPUnit_Framework_AssertionFailedError $eFail) {
                if ($eFail->getMessage() === self::ERROR_EXCEPTION_NOT_THROWN) {
                    throw $eFail;
                } else {
                    $this->assertEquals($p_sExpected, $eFail->getMessage());
                }
            }
        }

        /**
         * @test
         */
        final public function abstractTestCaseShouldCloseMockeryWhenItIsLoaded()
        {
            $this->markTestIncomplete('Not sure how to test this...');
        }

        ////////////////////////////// MOCKS AND STUBS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        /////////////////////////////// DATAPROVIDERS \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        /**
         * @return array[]
         */
        public function provideExposedPropertiesList()
        {
            return array(
                array(
                    'The following class properties need to be made private:' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> backupGlobals (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> backupGlobalsBlacklist (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> backupStaticAttributes (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> backupStaticAttributesBlacklist (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> runTestInSeparateProcess (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> preserveGlobalState (protected)' . PHP_EOL
                )
            );
        }

        /**
         * @return array[]
         */
        public function provideExposedMethodsList()
        {
            return array(
                array(
                    'The following class methods need to be made abstract, final or private:' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> __construct (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> toString (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> count (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getAnnotations (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getName (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getSize (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getActualOutput (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> hasOutput (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> expectOutputRegex (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> expectOutputString (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> hasPerformedExpectationsOnOutput (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> hasExpectationOnOutput (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getExpectedException (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setExpectedException (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setExpectedExceptionRegExp (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setExpectedExceptionFromAnnotation (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setUseErrorHandler (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setUseErrorHandlerFromAnnotation (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> checkRequirements (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getStatus (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getStatusMessage (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> hasFailed (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> run (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> runBare (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> runTest (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> verifyMockObjects (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setName (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setDependencies (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> hasDependencies (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setDependencyInput (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setBackupGlobals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setBackupStaticAttributes (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setRunTestInSeparateProcess (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setPreserveGlobalState (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setInIsolation (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> isInIsolation (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getResult (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setResult (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setOutputCallback (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getTestResultObject (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setTestResultObject (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> iniSet (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setLocale (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getMock (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getMockBuilder (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getMockClass (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getMockForAbstractClass (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getMockFromWsdl (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getMockForTrait (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getObjectForTrait (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> addToAssertionCount (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getNumAssertions (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> any (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> never (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> atLeast (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> atLeastOnce (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> once (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> exactly (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> atMost (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> at (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> returnValue (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> returnValueMap (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> returnArgument (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> returnCallback (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> returnSelf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> throwException (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> onConsecutiveCalls (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> dataToString (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getDataSetAsString (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> createResult (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> handleDependencies (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setUpBeforeClass (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> setUp (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> assertPreConditions (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> assertPostConditions (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> tearDownAfterClass (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> onNotSuccessfulTest (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> prepareTemplate (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_TestCase -> getMockObjectGenerator (protected)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertArrayHasKey (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertArraySubset (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertArrayNotHasKey (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertContains (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeContains (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotContains (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotContains (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertContainsOnly (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertContainsOnlyInstancesOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeContainsOnly (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotContainsOnly (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotContainsOnly (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertCount (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeCount (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotCount (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotCount (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertEquals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeEquals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotEquals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotEquals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertEmpty (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeEmpty (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotEmpty (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotEmpty (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertGreaterThan (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeGreaterThan (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertGreaterThanOrEqual (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeGreaterThanOrEqual (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertLessThan (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeLessThan (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertLessThanOrEqual (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeLessThanOrEqual (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertFileEquals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertFileNotEquals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringEqualsFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringNotEqualsFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertFileExists (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertFileNotExists (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertTrue (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotTrue (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertFalse (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotFalse (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotNull (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNull (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertClassHasAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertClassNotHasAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertClassHasStaticAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertClassNotHasStaticAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertObjectHasAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertObjectNotHasAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertSame (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeSame (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotSame (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotSame (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertInstanceOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeInstanceOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotInstanceOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotInstanceOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertInternalType (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeInternalType (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotInternalType (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertAttributeNotInternalType (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertRegExp (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotRegExp (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertSameSize (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotSameSize (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringMatchesFormat (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringNotMatchesFormat (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringMatchesFormatFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringNotMatchesFormatFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringStartsWith (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringStartsNotWith (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringEndsWith (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertStringEndsNotWith (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertXmlFileEqualsXmlFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertXmlFileNotEqualsXmlFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertXmlStringEqualsXmlFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertXmlStringNotEqualsXmlFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertXmlStringEqualsXmlString (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertXmlStringNotEqualsXmlString (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertEqualXMLStructure (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertSelectCount (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertSelectRegExp (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertSelectEquals (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertTag (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertNotTag (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertThat (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertJson (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertJsonStringEqualsJsonString (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertJsonStringNotEqualsJsonString (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertJsonStringEqualsJsonFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertJsonStringNotEqualsJsonFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertJsonFileNotEqualsJsonFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> assertJsonFileEqualsJsonFile (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> logicalAnd (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> logicalOr (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> logicalNot (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> logicalXor (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> anything (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> isTrue (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> callback (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> isFalse (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> isJson (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> isNull (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> attribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> contains (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> containsOnly (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> containsOnlyInstancesOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> arrayHasKey (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> equalTo (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> attributeEqualTo (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> isEmpty (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> fileExists (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> greaterThan (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> greaterThanOrEqual (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> classHasAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> classHasStaticAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> objectHasAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> identicalTo (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> isInstanceOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> isType (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> lessThan (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> lessThanOrEqual (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> matchesRegularExpression (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> matches (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> stringStartsWith (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> stringContains (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> stringEndsWith (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> countOf (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> fail (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> readAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> getStaticAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> getObjectAttribute (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> markTestIncomplete (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> markTestSkipped (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> getCount (public)' . PHP_EOL
                    . ' - PHPUnit_Framework_Assert -> resetCount (public)' . PHP_EOL
                )
            );
        }
    }
}
/*EOF*/
