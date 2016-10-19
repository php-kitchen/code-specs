<?php
namespace Tests\DeKey\Tester\Base;

/**
 * Represents base class for all of the test cases.
 *
 * @author Dmitry Kolodko <dangel.dekey@gmail.com>
 */
class TestCase extends \PHPUnit\Framework\TestCase {
    const FIXTURES_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR;
}