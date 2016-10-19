# Array expectations examples

In the following example we check that given array not empty, has expected key and value.

```php
public function testTheArray() {
        $tester = $this->tester;
        $tester->checksScenario('working wih associative array')
            ->expectsThat('array has both key and value')
            ->theArray(['key' => 'value'])
            ->isNotEmpty()
            ->hasKey('key')
            ->contains('value');
}
```