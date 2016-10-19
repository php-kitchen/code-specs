# Class expectations

In the following example we check that given class exists and not an interface.

```php
public function testTheClass() {
        $tester = $this->tester;
        $thisClass = get_class($this);
        $tester->checksScenario('working wih classes')
            ->expectsThat('given existing class')
            ->theClass($thisClass)
            ->isExist()
            ->isNotInterface();
}
```