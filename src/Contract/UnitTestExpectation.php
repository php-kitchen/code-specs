<?php
namespace DeKey\Tester\Contract;

use DeKey\Tester\Matchers\ArrayMatcher;
use DeKey\Tester\Matchers\BooleanMatcher;
use DeKey\Tester\Matchers\ClassMatcher;
use DeKey\Tester\Matchers\DirectoryMatcher;
use DeKey\Tester\Matchers\FileMatcher;
use DeKey\Tester\Matchers\NumberMatcher;
use DeKey\Tester\Matchers\ObjectMatcher;
use DeKey\Tester\Matchers\StringMatcher;
use DeKey\Tester\Matchers\ValueMatcher;

/**
 * Represents expectation of unit tests. Defines a list of methods available for unit tester.
 *
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
interface UnitTestExpectation extends ScenarioExpectation {
    /**
     * @param mixed $value actual value
     * @return ValueMatcher matcher responsible for value expectations handling.
     */
    public function valueOf($value);

    /**
     * Allows to run run inspection on number variables. Currently supports only few methods for
     * verification NAN, finite and infinite values.
     *
     * @param mixed $number actual number value.
     * @return NumberMatcher matcher responsible for number expectations handling.
     */
    public function number($number);

    /**
     * Allows to run run inspection on boolean variables. Allows simply to verify true/false values.
     *
     * @param mixed $variable actual bool variable
     * @return BooleanMatcher matcher responsible for variable expectations handling.
     */
    public function boolean($variable);

    /**
     * Allows to run run inspection on strings.
     * Includes various inspections like verification that string contains specific characters, is json or starts with specific character, etc.
     *
     * @param string $variable actual string variable.
     * @return StringMatcher matcher responsible for variable expectations handling.
     */
    public function string($variable);

    /**
     * Allows to run run inspection on array or objects that can be treated as array.
     * Includes various inspections like verification that array has specific values, keys or subsets, etc.
     *
     * @param array|\ArrayAccess $variable array or object that can be treated as array.
     * @return ArrayMatcher matcher responsible for variable expectations handling.
     */
    public function theArray($variable);

    /**
     * Allows to run run inspection on ant objects. For example to check whether object is an instance of specific class,
     * has attribute, etc.
     *
     * @param object $object actual object
     * @return ObjectMatcher matcher responsible for object expectations handling.
     */
    public function object($object);

    /**
     * Allows to run run inspection on classes (or interfaces of classes). For example to check whether class exist or not.
     *
     * @param mixed $class full class name.
     * @return ClassMatcher matcher responsible for object expectations handling.
     */
    public function theClass($class);

    /**
     * Allows to run run inspection on filesystem files. For example to check whether file exist or not.
     * Or to compare contests of two files.
     *
     * @param mixed $file full path to file.
     * @return FileMatcher matcher responsible for file expectations handling.
     */
    public function file($file);

    /**
     * Allows to run run inspection on filesystem directories. For example to check whether directory exist or not.
     *
     * @param mixed $directory full path to directory.
     * @return DirectoryMatcher matcher responsible for directory expectations handling.
     */
    public function directory($directory);
}