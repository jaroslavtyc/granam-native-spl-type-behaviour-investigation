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
        $instance = new SplString(null, true);
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function is_strict_by_default()
    {
        // we are expecting same behaviour as by null_is_refused_by_exception_if_strict
        new SplString(null);
    }

    /** @test */
    public function can_be_created_with_null_if_not_strict()
    {
        $instance = new SplString(null, false);
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_empty_string_if_not_strict()
    {
        $instance = new SplString('', false);
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_integer_if_not_strict()
    {
        $instance = new SplString(0, false);
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_float_if_not_strict()
    {
        $instance = new SplString(0.0, false);
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function true_if_not_strict_throws_exception()
    {
        new SplString(true);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function object_if_not_strict_throws_exception()
    {
        new SplString(new stdClass());
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function resource_if_not_strict_throws_exception()
    {
        new SplString(tmpfile());
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     * @expectedExceptionMessage Value not a string
     */
    public function callback_if_not_strict_throws_exception()
    {
        new SplString(function () {
        });
    }
}
