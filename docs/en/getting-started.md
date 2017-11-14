# Getting started

With Tester you build your expectation by chaining method calls of a tester. All of the expectations have following format:
```php
$I = $this->tester;
$I->{describe - optional}
$I->{verifyThat - optional}
$I->{expectThat|expectTo - optional}
$I->{lootAt - optional}
$I->{type of a variable}->{expectations of a variable}
```

Explanation for the format parts:
* describe - optional method that defines scenario tester checks. If test fails scenario would be displayed at the top of error message beginning with "I describe " 
* verifyThat - defines a group of expectations. You can either use a simple form with message only - `$I->verifyThat('remote service is acceptable');` or full form with callable that organize expectations([see test example](examples/tests/IncomeCalculatorTest.php). If a test fails this message will be put to console output beginning with "I verify that ".
* expectsThat|expectsTo|verifyThat - defines the expectations of a tester. If a test fails this message will be put to console output beginning with "I expect that ", "I expect to " 
* lookAt - defines a name of a variable that would be tested. If a test fails this name would be used to print step message, for example  "I see that user is not empty ", "I see that response has key 'data'" etc. 
* type of a variable - defines a type of variable being examined. Type of a variable defines what matcher to use. Following matchers are available:
  * see - means no type is specified. Starts a chain of basic "value" expectations.
  * seeNumber - starts a chain of expectations available for "number" types. Also includes all of the "value" expectations. 
  * seeBool - starts a chain of expectations available for "boolean" type. Also includes all of the "value" expectations. 
  * seeString - starts a chain of expectations available for "string" type. Also includes all of the "value" expectations.
  * seeArray - starts a chain of expectations available for "array" type. Also includes all of the "value" expectations. 
  * seeObject - starts a chain of expectations available for any objects. Also includes all of the "value" expectations. 
  * seeClass - starts a chain of expectations available for classes. Does not include any of the expectations previously mentioned.
  * seeFile - starts a chain of expectations available for a filesystem files. Does not include any of the expectations previously mentioned.
  * seeDirectory - starts a chain of expectations available for a filesystem directories. Does not include any of the expectations previously mentioned.

Each of expectation generally begin from words "is" or "has" or "isNot", "doesNotHave". 
So if you want to check that value have some state you can type "is" and see available methods in your IDE. If you want to check that value have something, you can type "has" and see available methods in your IDE.

Each of the methods that tests variables(or values) called matchers and begins with "see". Matcher methods can receive only one argument - value that should me tested.
If you don't care about readable output in console (why? readable output is so fun=) ) you can use matcher methods right away, like:
```php
$myDummyVariable = false;
$I->seeBool($myDummyVariable)->isTrue();
```
This way you'll get output in console says "I see that boolean is true."
Dut if you do care about readable output in console (and this is the way we would recommend yo to use) you can use `lootAt` methods with string that represents variable meaning as a first argument like:

```php
$myDummyVariable = false;
$I->lookAt('my dummy variable');
$I->seeBool($myDummyVariable)->isTrue();
```
This way you'll get output in console says "I see that my dummy variable is true."

See more examples on how to use expectations in [Examples](examples-list.md) section.