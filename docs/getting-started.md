# Getting started

With Tester you build your expectation by chaining method calls of a tester. All of the expectations have following format:
```php
$tester = $this->tester;
$tester->{checksSpecification - optional}->{expectsThat|expectsTo - required}->{type of a variable}->{expectations of a variable}
```

Explanation for the format parts:
* checksSpecification - optional method that defines scenario tester checks. If test fails scenario would be displayed at the top of error message beginning with "Scenario: " 
* expectsThat|expectsTo - defines the expectations of a tester. If a test fails this message will be put to console output beginning with "Tester expects that " or "Tester expects to ". You can leave message empty.
* type of a variable - defines a type of variable being examined. Following types are available:
  * valueOf - means no type is specified. Starts a chain of basic "value" expectations.
  * number - starts a chain of expectations available for "number" types. Also includes all of the "valueOf" expectations. 
  * boolean - starts a chain of expectations available for "boolean" type. Also includes all of the "valueOf" expectations. 
  * string - starts a chain of expectations available for "string" type. Also includes all of the "valueOf" expectations.
  * theArray - starts a chain of expectations available for "array" type. Also includes all of the "valueOf" expectations. 
  * object - starts a chain of expectations available for any objects. Also includes all of the "valueOf" expectations. 
  * theClass - starts a chain of expectations available for classes. Does not include any of the expectations previously mentioned.
  * file - starts a chain of expectations available for a filesystem files. Does not include any of the expectations previously mentioned.
  * directory - starts a chain of expectations available for a filesystem directories. Does not include any of the expectations previously mentioned.

Each of expectation generally begin from words "is" or "has" or "isNot", "doesNotHave". 
So if you want to check that value have some state you can type "is" and see available methods in your IDE. If you want to check that value have something, you can type "has" and see available methods in your IDE 