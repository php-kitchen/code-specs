# File matcher usage

In the following example we check that given file exists, is readable and equal to expected file(for example to itself).

```php
/**
 * @test
 */
public function fileExampleBehavior() {
        $I = $this->tester;
        $I->describe('working wih files');
        $I->expectThat('given file is accessible');
        $I->seeFile(__FILE__)
            ->isExist()
            ->isReadable()
            ->isEqualTo(__FILE__);
}
```