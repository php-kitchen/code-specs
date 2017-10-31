# Value expectations

In the following displayed basic usage of tester library to compare two values an verify given value match all of the expectations.

```php
/**
 * @test
 */
public function valueOfExampleSpec() {
        $I = $this->tester;
        $I->describe('process of testing values without any requirements for type-specific expectations');
        $I->expectThat('everything works');
        $I->seeValueOf(10)
            ->isNotEmpty()
            ->isNotNull()
            ->isTheSameAs(10)
            ->isNotTheSameAs(15);
}
```