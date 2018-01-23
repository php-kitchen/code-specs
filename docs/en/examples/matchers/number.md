# Number matcher usage

In the following example we check that given number is finite.

```php
/**
 * @test
 */
public function numberFiniteExampleBehavior() {
        $I = $this->tester;
        $I->seeNumber(1)
            ->isFinite();
}
```

In the following example we check that given number is infinite.

```php
/**
 * @test
 */
public function numberInfiniteEExampleBehavior() {
        $I = $this->tester;
        $I->seeNumber(INF)
            ->isInfinite();
}
```

In the following example we check that given number is NAN.

```php
public function numberNanExampleBehavior() {
        $I = $this->tester;
        $I->seeNumber(NAN)
            ->isNan();
}
```