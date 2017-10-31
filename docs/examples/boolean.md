# Boolean expectations

In the following example we check that given value is true not false.

```php
/**
 * @test
 */
public function booleanTroothExampleSpec() {
        $I = $this->tester;
        $I->seeBool('result of execution', true)
            ->isTrue();
}
```

In the following example we check that given value is not false.

```php
/**
 * @test
 */
public function  booleanNegativeAssertExampleSpec() {
        $I = $this->tester;
        $I->seeBool('result of execution', 1)
            ->isNotFalse();
}
```