##2.0.0

### New features
* Added `DeKey\Tester\Specification\Specification` class that can be used as a base class for your tests
* All of the expectation methods moved to tester and renamed to begin with "seeThat", like `$I->seeThatBoolean('dummy variable', true)->isFalse()` 
* Expectation methods now can accept name of the value as a first argument to print this name in error output

### BC breaks and deprecations
* Removed `and` from matchers
* Removed 'that' from matchers
* `expectsTahat`, `expectsTo`, `checksScenario` are deprecated and would be removed soon
* Removed Tester name personalization abilities
* Renamed Tester class to `DeKey\Tester\Specification\Tester`
* `whenInvokedMethod` of "object" matcher is deprecated - use new `when` method.