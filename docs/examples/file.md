# File expectations

In the following example we check that given file exists, is readable and equal to expected file(for example to itself).

```php
/**
 * @test
 */
public function fileExampleSpec() {
        $I = $this->tester;
        $I->describe('working wih files');
        $I->expectThat('given file is accessible');
        $I->seeThatFile(__FILE__)
            ->isExist()
            ->isReadable()
            ->isEqualTo(__FILE__);
}
```