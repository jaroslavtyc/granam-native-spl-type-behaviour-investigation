<?php
namespace Granam\Clones\Tests;

class SplTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function has_only_single_constant_with_expected_name()
    {
        $classReflection = new \ReflectionClass(\SplType::class);
        $this->assertSame(['__default' => null], $classReflection->getConstants());
    }

    /** @test */
    public function constructor_has_two_parameters()
    {
        $classReflection = new \ReflectionClass(\SplType::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(2, $constructorReflection->getNumberOfParameters());
    }

    /** @test */
    public function constructor_has_only_optional_parameters()
    {
        $classReflection = new \ReflectionClass(\SplType::class);
        $constructorReflection = $classReflection->getConstructor();
        $this->assertSame(0, $constructorReflection->getNumberOfRequiredParameters());
    }

    /** @test */
    public function constructor_parameters_are_named_as_expected()
    {
        $classReflection = new \ReflectionClass(\SplType::class);
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
    public function with_default_values_is_empty_string_as_string()
    {
        $instance = new SplTypeChild();
        $this->assertSame('', (string)$instance);
    }

    /** @test */
    public function with_null_is_empty_string_as_string()
    {
        $instance = new SplTypeChild(null);
        $this->assertSame('', (string)$instance);
    }

    /** @test */
    public function with_false_is_empty_string_as_string()
    {
        $instance = new SplTypeChild(false);
        $this->assertSame('', (string)$instance);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function with_true_throws_exception()
    {
        new SplTypeChild(true);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function with_true_throws_exception_even_not_strict()
    {
        new SplTypeChild(true, false);
    }

    /** @test */
    public function with_empty_string_is_the_same_as_string()
    {
        $instance = new SplTypeChild('');
        $this->assertSame('', (string)$instance);
    }

    /** @test */
    public function with_empty_array_is_empty_string_as_string()
    {
        $instance = new SplTypeChild([]);
        $this->assertSame('', (string)$instance);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function not_empty_array_throws_exception()
    {
        new SplTypeChild(['foo', 'bar']);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function not_empty_array_throws_exception_even_not_strict()
    {
        new SplTypeChild(['foo', 'bar'], false);
    }

    /** @test */
    public function with_zero_integer_is_empty_string_as_string()
    {
        $instance = new SplTypeChild(0);
        $this->assertSame('', (string)$instance);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function with_non_zero_integer_throws_exception()
    {
        new SplTypeChild(123456);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function with_non_zero_integer_throws_exception_even_if_not_strict()
    {
        new SplTypeChild(123456, false);
    }

    /** @test */
    public function with_zero_float_is_empty_string_as_string()
    {
        $instance = new SplTypeChild(0.0);
        $this->assertSame('', (string)$instance);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function with_non_zero_float_throws_exception()
    {
        new SplTypeChild(123456.789123);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function with_non_zero_float_throws_exception_even_if_not_strict()
    {
        new SplTypeChild(123456.789123, false);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function object_throws_exception()
    {
        new SplTypeChild(new \stdClass());
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function object_throws_exception_even_not_strict()
    {
        new SplTypeChild(new \stdClass(), false);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function resource_throws_exception()
    {
        new SplTypeChild(tmpfile());
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function resource_throws_exception_even_not_strict()
    {
        new SplTypeChild(tmpfile(), false);
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function callback_throws_exception()
    {
        new SplTypeChild(function () {
        });
    }

    /**
     * @test
     * @expectedException \UnexpectedValueException
     * @expectedExceptionMessage Value not a const in enum Granam\Clones\Tests\SplTypeChild
     */
    public function callback_throws_exception_even_not_strict()
    {
        new SplTypeChild(
            function () {
            },
            false
        );
    }
}

/** inner */
class SplTypeChild extends \SplType
{

}
