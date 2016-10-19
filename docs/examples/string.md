# String expectations

In the following example we check that given string contains information(not empty and not null), contains expected characters, starts and ends with expected characters and does not equal to other string.

```php
public function testString() {
        $tester = $this->tester;
        $tester->checksScenario('working with strings')
            ->expectsThat('received expected string with required characters')
            ->string('abcdefg')
            ->isNotEmpty()
            ->isNotNull()
            ->isNotTheSameAs('gfedcba')
            ->contains('a')
            ->doesNotContain('x')
            ->startsWith('a')
            ->endsWith('g');
}