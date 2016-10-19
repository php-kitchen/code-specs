# Boolean expectations

In the following example we check that given value is true not false.

```php
public function testBoolean() {
        $tester = $this->tester;
        $tester->expectsThat()
            ->boolean(true)
            ->isTrue();
}
```

In the following example we check that given value is not false.

```php
public function testBoolean() {
        $tester = $this->tester;
        $tester->expectsThat()
            ->boolean(1)
            ->isNotFalse();
}
```