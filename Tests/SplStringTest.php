<?php

class SplStringTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function has_only_single_constant_with_expected_name_and_value()
    {
        $classReflection = new \ReflectionClass(SplString::class);
        $this->assertSame(['__default' => ''], $classReflection->getConstants());
    }

    /** @test */
    public function constructor_has_two_parameters()
    {
        $classReflection = new \ReflectionClass(SplString::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(2, $constructorReflection->getNumberOfParameters());
    }

    /** @test */
    public function constructor_has_only_optional_parameters()
    {
        $classReflection = new \ReflectionClass(SplString::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(0, $constructorReflection->getNumberOfRequiredParameters());
    }

    /** @test */
    public function constructor_parameters_are_names_as_expected()
    {
        $classReflection = new \ReflectionClass(SplString::class);
        $constructorReflection = $classReflection->getConstructor();
        $reflectionParameters = $constructorReflection->getParameters();
        $parameterNames = array_map(
            function (\ReflectionParameter $reflectionParameter) {
                return $reflectionParameter->getName();
            },
            $reflectionParameters
        );
        $this->assertSame(['initial_value', 'strict'], $parameterNames);
    }

    /** @test */
    public function constructor_parameters_are_not_passed_by_reference()
    {
        $classReflection = new \ReflectionClass(SplString::class);
        $constructorReflection = $classReflection->getConstructor();
        $reflectionParameters = $constructorReflection->getParameters();
        $initial_value = $reflectionParameters[0];
        $this->assertSame('initial_value', $initial_value->getName());
        $this->assertFalse($initial_value->isPassedByReference());
        $strict = $reflectionParameters[1];
        $this->assertSame('strict', $strict->getName());
        $this->assertFalse($strict->isPassedByReference());
    }

    /** @test */
    public function can_be_created_with_default_values()
    {
        $instance = new SplString();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function null_is_refused_by_exception_if_strict()
    {
        new SplString(null, true);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function is_strict_by_default()
    {
        /**
         * we are expecting same behaviour as by null_is_refused_by_exception_if_strict
         * @see null_is_refused_by_exception_if_strict
         */
        new SplString(null);
    }

    /** @test */
    public function null_if_not_strict_is_empty_string()
    {
        $splString = new SplString(null, false);
        $this->assertSame('', (string)$splString);
    }

    /** @test */
    public function empty_string_if_not_strict_is_empty_string()
    {
        $splString = new SplString('', false);
        $this->assertSame('', (string)$splString);
    }

    /** @test */
    public function a_string_if_not_strict_is_that_string()
    {
        $splString = new SplString('foo', false);
        $this->assertSame('foo', (string)$splString);
    }

    /** @test */
    public function integer_if_not_strict_is_string_with_that_integer()
    {
        $splString = new SplString(0, false);
        $this->assertSame('0', (string)$splString);
    }

    /** @test */
    public function zero_float_if_not_strict_is_string_with_zero_integer()
    {
        $splString = new SplString(0.0, false);
        $this->assertSame('0', (string)$splString);
    }

    /** @test */
    public function non_zero_float_if_not_strict_is_string_with_that_float()
    {
        $splString = new SplString(0.1, false);
        $this->assertSame('0.1', (string)$splString);
    }

    /** @test */
    public function almost_integer_float_if_not_strict_is_string_with_rounded_integer()
    {
        $float = 0.9999999999999999;
        $splString = new SplString($float, false);
        $this->assertSame('1', (string)$splString);
        $this->assertSame((string)$float, (string)$splString);
    }

    /** @test */
    public function array_if_not_strict_cause_array_to_string_notice()
    {
        $originalErrorReporting = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE); // notices temporary disabled
        $lineBeforeExpectedNotice = __LINE__;
        $splString = new SplString(['foo', 'bar'], false);
        error_reporting($originalErrorReporting); // restoring previous error reporting
        $lastError = error_get_last();
        $this->assertInternalType('array', $lastError);
        $this->assertTrue(!empty($lastError['type']));
        $this->assertSame(8, $lastError['type']);
        $this->assertTrue(!empty($lastError['message']));
        $this->assertSame('Array to string conversion', $lastError['message']);
        $this->assertTrue(!empty($lastError['file']));
        $this->assertSame(__FILE__, $lastError['file']);
        $this->assertTrue(!empty($lastError['line']));
        $this->assertSame($lineBeforeExpectedNotice + 1, $lastError['line']);
        $this->assertSame('Array', (string)$splString);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object of class stdClass could not be converted to string
     */
    public function object_cause_notice_and_throws_exception_if_not_strict()
    {
        $originalErrorReporting = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE); // notices temporary disabled
        $twoLinesBeforeExpectedNotice = __LINE__;
        try {
            new SplString(new \stdClass(), false);
        } catch (\Exception $exception) {
            $lastError = error_get_last();
            $this->assertInternalType('array', $lastError);
            $this->assertTrue(!empty($lastError['type']));
            $this->assertSame(8, $lastError['type']);
            $this->assertTrue(!empty($lastError['message']));
            $this->assertSame('Object of class stdClass to string conversion', $lastError['message']);
            $this->assertTrue(!empty($lastError['file']));
            $this->assertSame(__FILE__, $lastError['file']);
            $this->assertTrue(!empty($lastError['line']));
            $this->assertSame($twoLinesBeforeExpectedNotice + 2, $lastError['line']);
            throw $exception;
        } finally {
            error_reporting($originalErrorReporting); // restoring previous error reporting
        }
    }

    /** @test */
    public function resource_if_not_strict_is_silently_converted_to_its_name()
    {
        $splString = new SplString(tmpfile(), false);
        $this->assertRegExp('~^Resource id #\d+$~', (string)$splString);
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Object of class Closure could not be converted to string
     */
    public function closure_cause_notice_and_throws_exception_if_not_strict()
    {
        $originalErrorReporting = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE); // notices temporary disabled
        $threeLinesBeforeExpectedNotice = __LINE__;
        try {
            new SplString(function () {
            }, false);
        } catch (\Exception $exception) {
            $lastError = error_get_last();
            $this->assertInternalType('array', $lastError);
            $this->assertTrue(!empty($lastError['type']));
            $this->assertSame(8, $lastError['type']);
            $this->assertTrue(!empty($lastError['message']));
            $this->assertSame('Object of class Closure to string conversion', $lastError['message']);
            $this->assertTrue(!empty($lastError['file']));
            $this->assertSame(__FILE__, $lastError['file']);
            $this->assertTrue(!empty($lastError['line']));
            $this->assertSame($threeLinesBeforeExpectedNotice + 3, $lastError['line']);
            throw $exception;
        } finally {
            error_reporting($originalErrorReporting); // restoring previous error reporting
        }
    }

    /** @test */
    public function empty_string_if_strict_is_empty_string()
    {
        $splString = new SplString('');
        $this->assertSame('', (string)$splString);
    }

    /** @test */
    public function a_string_if_strict_is_that_string()
    {
        $splString = new SplString('foo');
        $this->assertSame('foo', (string)$splString);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function integer_if_strict_throws_exception()
    {
        new SplString(0);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function float_if_strict_throws_exception()
    {
        new SplString(0.0);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function true_if_strict_throws_exception()
    {
        new SplString(true);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function false_if_strict_throws_exception()
    {
        new SplString(false);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function array_if_strict_throws_exception()
    {
        new SplString([]);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function object_if_strict_throws_exception()
    {
        new SplString(new stdClass());
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function resource_if_strict_throws_exception()
    {
        new SplString(tmpfile());
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function callback_if_strict_throws_exception()
    {
        new SplString(function () {
        });
    }
}
