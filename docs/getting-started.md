# Getting started

With Tester you build your expectation by chaining method calls of a tester. All of the expectations have following format:
```php
$I = $this->tester;
$I->{describe - optional}
$I->{expectsThat|expectsTo|verifyThat - required}
$I->{type of a variable}->{expectations of a variable}
```

Explanation for the format parts:
* describe - optional method that defines scenario tester checks. If test fails scenario would be displayed at the top of error message beginning with "I describe " 
* expectsThat|expectsTo|verifyThat - defines the expectations of a tester. If a test fails this message will be put to console output beginning with "I expects tha ", "I expects to " or "I verify to ". You can leave message empty.
* type of a variable - defines a type of variable being examined. Following types are available:
  * see - means no type is specified. Starts a chain of basic "value" expectations.
  * seeNumber - starts a chain of expectations available for "number" types. Also includes all of the "valueOf" expectations. 
  * seeBool - starts a chain of expectations available for "boolean" type. Also includes all of the "valueOf" expectations. 
  * seeString - starts a chain of expectations available for "string" type. Also includes all of the "valueOf" expectations.
  * seeArray - starts a chain of expectations available for "array" type. Also includes all of the "valueOf" expectations. 
  * seeObject - starts a chain of expectations available for any objects. Also includes all of the "valueOf" expectations. 
  * seeClass - starts a chain of expectations available for classes. Does not include any of the expectations previously mentioned.
  * seeFile - starts a chain of expectations available for a filesystem files. Does not include any of the expectations previously mentioned.
  * seeDirectory - starts a chain of expectations available for a filesystem directories. Does not include any of the expectations previously mentioned.

Each of expectation generally begin from words "is" or "has" or "isNot", "doesNotHave". 
So if you want to check that value have some state you can type "is" and see available methods in your IDE. If you want to check that value have something, you can type "has" and see available methods in your IDE.

Each of the methods that tests variables(or values) begins with "see" and can receive one or two arguments.
If you don't care about readable output in console (why - readable output is so fun=) ) you can pass variable directly to method like:
```php
$myDummyVariable = false;
$I->seeBool($myDummyVariable)->isTrue();
```
This way you'll get output in console says "I see that boolean is true."
Dut if you do care about readable output in console (and this is the way I would recommend yo to go) you can pass string with variable meaning as a first argument and a variable directly as a second argument like:

```php
$myDummyVariable = false;
$I->seeBool('my dummy variable', $myDummyVariable)->isTrue();
```
This way you'll get output in console says "I see that my dummy variable is true."

See more examples on how to use expectations in [Examples](examples-list.md) section.