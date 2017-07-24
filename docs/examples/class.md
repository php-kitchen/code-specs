# Class expectations

In the following example we check that given class exists and not an interface.

```php
/**
 * @test
 */
public function classExampleSpec() {
        $I = $this->tester;
        $thisClass = get_class($this);
        $I->describe('process of class testing');
        $I->expectThat('my class is a valid existing class');
        $I->seeThatClass($thisClass)
            ->isExist()
            ->isNotInterface();
}
```