<?php

namespace PHPKitchen\CodeSpecs\Expectation\Dispatcher;

/**
 * Extends base dispatcher to delay asserts.
 *
 * Asserts won;t be executed once they are called and only would be started when
 * matcher object would ca called as a function.
 *
 * For example:
 * <code>
 *  $delayedMatcher = $dispatcher->isArray()->isNotEmpty()->hasKey('name');
 *  $delayedMatcher($myArray);
 * </code>
 *
 * @package PHPKitchen\CodeSpecs\Expectation\Dispatchers
 * @author Dmitry Kolodko <prowwid@gmail.com>
 */
class DelayedDispatcher extends Dispatcher {
    protected function init(): void {
        $this->useDelayedAsserts = true;
    }
}