# Number expectations

In the following example we check that given number is finite.

```php
public function testNumber() {
        $tester = $this->tester;
        $tester->expectsThat()
            ->number(1)
            ->isFinite();
}
```

In the following example we check that given number is infinite.

```php
public function testNumber() {
        $tester = $this->tester;
        $tester->expectsThat()
            ->number(INF)
            ->isInfinite();
}
```

In the following example we check that given number is NAN.

```php
public function testNumber() {
        $tester = $this->tester;
        $tester->expectsThat()
            ->number(NAN)
            ->isNan();
}
```