# Object expectations

In the following example we check that given object is not empty an is an instance of expected class.

```php
public function testObject() {
        $tester = $this->tester;
        $tester->checksScenario('Example of basic usage')
            ->expectsThat('everything works')
            ->object($this)
            ->isNotEmpty()
            ->isInstanceOf(get_class($this));
}
```

In the following example we check that MyClass instance throws exception once 'throwException' method being invoked.

```php
/**
 * Our class that throw exceptions.
 */
class MyClass {
    public function throwException() {
        throw new \InvalidArgumentException('test exception');
    }
}

//..............

public function testObject() {
        $tester = $this->tester;
        $myObject = new MyClass();
        $tester->checksScenario('Example of basic usage')
            ->expectsThat('everything works')
            ->object($myObject)
            ->throwsException(\InvalidArgumentException::class)
            ->withMessage('test exception')
            ->whenInvokedMethod('throwException');
}
```