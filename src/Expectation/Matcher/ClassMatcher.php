<?php

namespace PHPKitchen\CodeSpecs\Expectation\Matcher;

use PHPKitchen\CodeSpecs\Expectation\Matcher\Base\Matcher;

/**
 * ClassMatcher is designed to check given class matches expectation.
 *
 * @package PHPKitchen\CodeSpecs\Expectation
 * @author Dima Kolodko <dima@kolodko.pro>
 */
class ClassMatcher extends Matcher {
    /**
     * @return $this
     */
    public function isExist(): self {
        $this->startStep('is exist')
             ->assertClassExists();

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotExist(): self {
        $this->startStep('is not exist')
             ->assertClassDoesNotExist();

        return $this;
    }

    /**
     * @return $this
     */
    public function isInterface(): self {
        $this->startStep('is interface')
             ->assertClassIsInterface();

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotInterface(): self {
        $this->startStep('is not interface')
             ->assertClassIsNotInterface();

        return $this;
    }

    /**
     * @return $this
     */
    public function hasStaticAttribute($attribute): self {
        $this->startStep("has static attribute \"{$attribute}\"")
             ->assertClassHasStaticAttribute($attribute);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotHaveStaticAttribute($attribute): self {
        $this->startStep("does not have static attribute \"{$attribute}\"")
             ->assertClassNotHasStaticAttribute($attribute);

        return $this;
    }

    /**
     * @return $this
     */
    public function hasAttribute($attribute): self {
        $this->startStep("has attribute \"{$attribute }\"")
             ->assertClassHasAttribute($attribute);

        return $this;
    }

    /**
     * @return $this
     */
    public function doesNotHaveAttribute($attribute): self {
        $this->startStep("does not have attribute \"{$attribute}\"")
             ->assertClassNotHasAttribute($attribute);

        return $this;
    }
}