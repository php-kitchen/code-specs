# String expectations

In the following example we check that given string contains information(not empty and not null), contains expected characters, starts and ends with expected characters and does not equal to other string.

```php
/**
 * @test
 */
public function stringExamplesSpec() {
        $I = $this->tester;
        $I->describe('process of testing strings');
        $I->expectThat('received expected string with required characters');
        $I->seeThatString('abcdefg')
            ->isNotEmpty()
            ->isNotNull()
            ->isNotTheSameAs('gfedcba')
            ->contains('a')
            ->doesNotContain('x')
            ->startsWith('a')
            ->endsWith('g');
}