# Array matcher usage examples

In the following example we check that given array not empty, has expected key and value.

```php
/**
 * @test
 */
public function arrayExampleBehavior() {
        $I = $this->tester;
        $I->describe('working wih associative array');
        $I->expectThat('array has both key and value');
        $I->seeArray('admin record', ['name' => 'Alex'])
            ->isNotEmpty()
            ->hasKey('name')
            ->contains('Alex');
}
```