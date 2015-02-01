<?php
namespace Granam\Clones\Tests;

/**
 * @requires extension spl_types
 */
class SplStringTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function has_only_single_constant_with_expected_name_and_value()
    {
        $classReflection = new \ReflectionClass(\SplString::class);
        $this->assertSame(['__default' => ''], $classReflection->getConstants());
    }

    /** @test */
    public function constructor_has_two_parameters()
    {
        $classReflection = new \ReflectionClass(\SplString::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(2, $constructorReflection->getNumberOfParameters());
    }

    /** @test */
    public function constructor_has_only_optional_parameters()
    {
        $classReflection = new \ReflectionClass(\SplString::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(0, $constructorReflection->getNumberOfRequiredParameters());
    }

    /** @test */
    public function constructor_parameters_are_names_as_expected()
    {
        $classReflection = new \ReflectionClass(\SplString::class);
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
        $classReflection = new \ReflectionClass(\SplString::class);
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
        $instance = new \SplString();
        $this->assertNotNull($instance);
        $this->assertSame('', (string)$instance);
    }

    /** @test */
    public function can_be_serialized_and_unserialized()
    {
        $instance = new \SplString();
        $this->assertNotSame($instance, unserialize(serialize($instance)));
        $this->assertEquals($instance, unserialize(serialize($instance)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function null_throws_exception_if_strict()
    {
        new \SplString(null, true);
    }

    /** @test */
    public function null_if_not_strict_is_empty_string()
    {
        $splString = new \SplString(null, false);
        $this->assertSame('', (string)$splString);
    }

    /** @test */
    public function null_if_not_strict_is_empty_string_after_serialization()
    {
        $splString = new \SplString(null, false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function is_strict_by_default()
    {
        /**
         * we are expecting same behaviour as by null_throws_exception_if_strict()
         * @see null_throws_exception_if_strict
         * in difference to strict mode tested by null_if_not_strict_is_empty_string
         * @see null_if_not_strict_is_empty_string
         */
        new \SplString(null, true);
    }

    /** @test */
    public function empty_string_if_strict_is_empty_string()
    {
        $splString = new \SplString('', true);
        $this->assertSame('', (string)$splString);
    }

    /** @test */
    public function empty_string_if_not_strict_is_empty_string()
    {
        $splString = new \SplString('', false);
        $this->assertSame('', (string)$splString);
    }

    /** @test */
    public function empty_string_if_not_strict_is_empty_string_after_serialization()
    {
        $splString = new \SplString('', false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /** @test */
    public function a_string_if_strict_is_that_string()
    {
        $splString = new \SplString('foo', true);
        $this->assertSame('foo', (string)$splString);
    }

    /** @test */
    public function a_string_if_not_strict_is_that_string()
    {
        $splString = new \SplString('foo', false);
        $this->assertSame('foo', (string)$splString);
    }

    /** @test */
    public function a_string_if_not_strict_is_not_lost_after_serialize()
    {
        $splString = new \SplString('foo', false);
        $this->assertSame('O:9:"SplString":1:{s:9:"__default";s:3:"foo";}', serialize($splString));
    }

    /** @test */
    public function a_string_if_not_strict_is_empty_string_after_serialization()
    {
        $splString = new \SplString('foo', false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function integer_if_strict_throws_exception()
    {
        new \SplString(0, true);
    }

    /** @test */
    public function integer_if_not_strict_is_string_with_that_integer()
    {
        $splString = new \SplString(0, false);
        $this->assertSame('0', (string)$splString);
    }

    /** @test */
    public function integer_if_not_strict_is_empty_string_after_serialization()
    {
        $splString = new \SplString(0, false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function zero_float_if_strict_throws_exception()
    {
        new \SplString(0.0, true);
    }

    /** @test */
    public function zero_float_if_not_strict_is_string_with_zero_integer()
    {
        $splString = new \SplString(0.0, false);
        $this->assertSame('0', (string)$splString);
    }

    /** @test */
    public function zero_float_if_not_strict_is_empty_string_after_serialization()
    {
        $splString = new \SplString(0.0, false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /** @test */
    public function non_zero_float_if_not_strict_is_string_with_that_float()
    {
        $splString = new \SplString(0.1, false);
        $this->assertSame('0.1', (string)$splString);
    }

    /** @test */
    public function non_zero_float_if_not_strict_is_empty_string_after_serialization()
    {
        $splString = new \SplString(0.1, false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function almost_integer_float_if_strict_throws_exception()
    {
        new \SplString(0.9999999999999999, true);
    }

    /** @test */
    public function almost_integer_float_if_not_strict_is_string_with_rounded_integer()
    {
        $float = 0.9999999999999999;
        $splString = new \SplString($float, false);
        $this->assertSame('1', (string)$splString);
        $this->assertSame((string)$float, (string)$splString);
    }

    /** @test */
    public function almost_integer_float_if_not_strict_is_empty_string_after_serialization()
    {
        $float = 0.9999999999999999;
        $splString = new \SplString($float, false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function true_if_strict_throws_exception()
    {
        new \SplString(true, true);
    }

    /**
     * @test
     */
    public function true_is_string_one_if_not_strict()
    {
        $splString = new \SplString(true, false);
        $this->assertSame('1', (string)$splString);
    }

    /**
     * @test
     */
    public function true_is_empty_string_if_not_strict_after_serialization()
    {
        $splString = new \SplString(true, false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function false_if_strict_throws_exception()
    {
        new \SplString(false, true);
    }

    /**
     * @test
     */
    public function false_is_empty_string_if_not_strict()
    {
        $splString = new \SplString(false, false);
        $this->assertSame('', (string)$splString);
    }

    /**
     * @test
     */
    public function false_is_empty_string_if_not_strict_after_serialization()
    {
        $splString = new \SplString(false, false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function array_if_strict_throws_exception()
    {
        new \SplString([], true);
    }

    /** @test */
    public function array_if_not_strict_cause_array_to_string_notice()
    {
        $originalErrorReporting = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE); // notices standard reporting temporary disabled
        $lineBeforeExpectedNotice = __LINE__;
        $splString = new \SplString(['foo', 'bar'], false);
        error_reporting($originalErrorReporting); // restoring previous error reporting
        $lastError = error_get_last();
        $this->assertInternalType('array', $lastError);
        $this->assertTrue(!empty($lastError['type']));
        $this->assertSame(E_NOTICE, $lastError['type']);
        $this->assertTrue(!empty($lastError['file']));
        $this->assertSame(__FILE__, $lastError['file']);
        $this->assertTrue(!empty($lastError['line']));
        $this->assertSame($lineBeforeExpectedNotice + 1, $lastError['line']);
        $this->assertTrue(!empty($lastError['message']));
        $this->assertSame('Array to string conversion', $lastError['message']);
        $this->assertSame('Array', (string)$splString);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function object_if_strict_throws_exception()
    {
        new \SplString(new \stdClass(), true);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Object of class stdClass could not be converted to string
     */
    public function object_cause_notice_and_throws_exception_even_not_strict()
    {
        $originalErrorReporting = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE); // notices standard reporting temporary disabled
        try {
            new \SplString(new \stdClass(), false);
        } catch (\Exception $exception) {
            $twoLinesAfterExpectedNotice = __LINE__;
            $lastError = error_get_last();
            $this->assertInternalType('array', $lastError);
            $this->assertTrue(!empty($lastError['type']));
            $this->assertSame(E_NOTICE, $lastError['type']);
            $this->assertTrue(!empty($lastError['file']));
            $this->assertSame(__FILE__, $lastError['file']);
            $this->assertTrue(!empty($lastError['line']));
            $this->assertSame($twoLinesAfterExpectedNotice - 2, $lastError['line']);
            $this->assertTrue(!empty($lastError['message']));
            $this->assertSame('Object of class stdClass to string conversion', $lastError['message']);
            throw $exception;
        } finally {
            error_reporting($originalErrorReporting); // restoring previous error reporting
        }
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function with_to_string_object_throws_exception_if_strict()
    {
        new \SplString(new WithToString('foo'), true);
    }

    /**
     * @test
     */
    public function with_to_string_object_is_that_string_as_string_if_not_strict()
    {
        $splString = new \SplString(new WithToString('foo'), false);
        $this->assertSame('foo', (string)$splString);
    }

    /**
     * @test
     */
    public function with_to_string_object_is_empty_string_as_string_if_not_strict_after_serialization()
    {
        $splString = new \SplString(new WithToString('foo'), false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function resource_if_strict_throws_exception()
    {
        new \SplString(tmpfile(), true);
    }

    /** @test */
    public function resource_if_not_strict_is_silently_converted_to_its_name()
    {
        $splString = new \SplString(tmpfile(), false);
        $this->assertRegExp('~^Resource id #\d+$~', (string)$splString);
    }

    /** @test */
    public function resource_if_not_strict_is_silently_converted_to_empty_string_after_serialization()
    {
        $splString = new \SplString(tmpfile(), false);
        $this->assertSame('', (string)unserialize(serialize($splString)));
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function callback_if_strict_throws_exception()
    {
        new \SplString(
            function () {
            },
            true
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Object of class Closure could not be converted to string
     */
    public function closure_cause_notice_and_throws_exception_even_not_strict()
    {
        $originalErrorReporting = error_reporting();
        error_reporting(E_ALL ^ E_NOTICE); // notices standard reporting temporary disabled
        try {
            new \SplString(
                function () {
                },
                false
            );
        } catch (\Exception $exception) {
            $twoLinesAfterExpectedNotice = __LINE__;
            $lastError = error_get_last();
            $this->assertInternalType('array', $lastError);
            $this->assertTrue(!empty($lastError['type']));
            $this->assertSame(E_NOTICE, $lastError['type']);
            $this->assertTrue(!empty($lastError['file']));
            $this->assertSame(__FILE__, $lastError['file']);
            $this->assertTrue(!empty($lastError['line']));
            $this->assertSame($twoLinesAfterExpectedNotice - 2, $lastError['line']);
            $this->assertTrue(!empty($lastError['message']));
            $this->assertSame('Object of class Closure to string conversion', $lastError['message']);
            throw $exception;
        } finally {
            error_reporting($originalErrorReporting); // restoring previous error reporting
        }
    }

}

/** inner */
class WithToString extends \stdClass
{
    private $string;

    /**
     * @param string $string
     */
    public function __construct($string)
    {
        $this->string = (string)$string;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }
}
