<?php

namespace Tests\Base;


/**
 * Represents base class for all of the test cases.
 *
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class TestCase extends \PHPUnit\Framework\TestCase {
    const FIXTURES_DIR = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR;
}
