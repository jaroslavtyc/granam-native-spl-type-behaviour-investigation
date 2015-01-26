<?php

class SplTypeTest extends \PHPUnit_Framework_TestCase
{

    /** @test */
    public function default_constant_is_null()
    {
        $this->assertNull(\SplType::__default);
    }

    /** @test */
    public function has_only_single_constant_with_expected_name()
    {
        $classReflection = new \ReflectionClass(SplType::class);
        $this->assertSame(['__default' => null], $classReflection->getConstants());
    }

    /** @test */
    public function constructor_has_two_parameters()
    {
        $classReflection = new \ReflectionClass(SplType::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(2, $constructorReflection->getNumberOfParameters());
    }

    /** @test */
    public function constructor_has_only_optional_parameters()
    {
        $classReflection = new \ReflectionClass(SplType::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(0, $constructorReflection->getNumberOfRequiredParameters());
    }

    /** @test */
    public function constructor_parameters_are_names_as_expected()
    {
        $classReflection = new \ReflectionClass(SplType::class);
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
    public function constructor_first_parameter_is_not_passed_by_reference()
    {
        $classReflection = new \ReflectionClass(SplType::class);
        $constructorReflection = $classReflection->getConstructor();
        $reflectionParameters = $constructorReflection->getParameters();
        $initial_value = $reflectionParameters[0];
        $this->assertSame('initial_value', $initial_value->getName());
        $this->assertFalse($initial_value->isPassedByReference());
    }

    /** @test */
    public function can_be_created_with_default_values()
    {
        $instance = new SplTypeChild();
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_null_as_first_parameter()
    {
        $instance = new SplTypeChild(null);
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_false_as_first_parameter()
    {
        $instance = new SplTypeChild(false);
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_empty_string_as_first_parameter()
    {
        $instance = new SplTypeChild('');
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_empty_array_as_first_parameter()
    {
        $instance = new SplTypeChild([]);
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_integer_as_first_parameter()
    {
        $instance = new SplTypeChild(0);
        $this->assertNotNull($instance);
    }

    /** @test */
    public function can_be_created_with_float_as_first_parameter()
    {
        $instance = new SplTypeChild(0.0);
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function true_as_first_parameter_throws_exception()
    {
        new SplTypeChild(true);
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function object_as_first_parameter_throws_exception()
    {
        new SplTypeChild(new stdClass());
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function resource_as_first_parameter_throws_exception()
    {
        new SplTypeChild(tmpfile());
    }

    /**
     * @test
     * @expectedException UnexpectedValueException
     */
    public function callback_as_first_parameter_throws_exception()
    {
        new SplTypeChild(function(){});
    }
}

/* inner */ class SplTypeChild extends \SplType
{

}
