<?php

namespace PHPKitchen\CodeSpecs\Mixin;

use PHPKitchen\CodeSpecs\Specification\Tester;

/**
 * Adds support of {@link Tester} in PHPUnit test classes.
 *
 * @package PHPKitchen\CodeSpecs
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
trait TesterInitialization {
    /**
     * @var Tester instance of tester. This property refreshing before each test.
     */
    public $tester;

    /**
     * @before
     */
    public function initTester() {
        $this->tester = $this->createTester();
    }

    /**
     * Creates tester instance before each test.
     * Override to specify custom tester or do other stuff you want.
     *
     * @return Tester tester instance.
     */
    public function createTester() {
        return new Tester($this);
    }
}