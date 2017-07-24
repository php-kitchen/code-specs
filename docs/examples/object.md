# Object expectations

In the following example we check that given object is not empty an is an instance of expected class.

```php
/**
 * @test
 */
public function objectExampleSpec() {
        $I = $this->tester;
        $I->describe('basic usage of object expectations');
        $I->expectThat('everything works');
        $I->seeThatObject($this)
            ->isNotEmpty()
            ->isInstanceOf(get_class($this));
}
```

In the following example we check that MyClass instance throws exception once 'throwException' method being invoked.

```php
/**
 * @test
 */
/**
 * Our class that throw exceptions.
 */
class MyClass {
    public function throwException() {
        throw new \InvalidArgumentException('test exception');
    }
}

//..............

public function objectExceptionExampleSpec() {
        $I = $this->tester;
        $myObject = new MyClass();
        $I->describe('how to test exceptions')
        $I->expectThat('everything works(really stupid expectation - I know=D)');
        $I->seeThatObject($myObject)
            ->throwsException(\InvalidArgumentException::class)
            ->withMessage('test exception')
            ->when(function(MyClass $object) {$object->throwException();});
}
```