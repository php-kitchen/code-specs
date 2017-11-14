# Directory matcher usage

In the following example we check that given directory exists and is readable.

```php
/**
 * @test
 */
public function directoryExampleSpec() {
        $I = $this->tester;
        $I->describe('process of testing directories');
        $I->expectThat('given directory is accessible');
        $I->seeDirectory(__DIR__)
            ->isExist()
            ->isReadable();
}
```