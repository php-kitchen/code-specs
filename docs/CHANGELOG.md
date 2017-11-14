## 3.0.0

### New features and updates
* Moved `PHPKitchen\CodeSpecs\TesterInitialization` to `PHPKitchen\CodeSpecs\Mixin\TesterInitialization` (BC kept by leaving old trait in place). New namespace world be used public mixins.
* Moved `PHPKitchen\CodeSpecs\Specification\Specification` to `\PHPKitchen\CodeSpecs\Base\Specification` (BC kept by leaving old class in place). New namespace world be used for base classes that users can extend in their own codebase.
* Added `php-kitchen/code-specs-core` as a dependency that would have all of the core code of CodeSpecs shared between PHPUnit and Codeception versions.
* Added `PHPKitchen\CodeSpecs\Specification\OldTester` to use it during migration to a new `PHPKitchen\CodeSpecs\Specification\Tester`. Will be removed in 4.0.
* Added [Runtime Matchers](https://github.com/php-kitchen/code-specs/blob/master/docs/en/runtime-matchers.md)
* Added [Directives](https://github.com/php-kitchen/code-specs/blob/master/docs/en/directives.md)
* Added [Wait Directive](https://github.com/php-kitchen/code-specs/blob/master/docs/en/examples/wait.md)

### BC breaks and deprecations
* Moved to a new organization with a new brand so root namespace changed to `PHPKitchen\CodeSpecs`.
* Removed `Matchers` as of `php-kitchen/code-specs-core` support.
* Removed `Contract` as of `php-kitchen/code-specs-core` support.
* Removed `whenInvoked` from `PHPKitchen\CodeSpecsCore\Expectation\Internal\ObjectExceptionMatcher`(`seeObject($obj)->throwsException($exceptionClass)`) as it was deprecated in 2.0
* All of `see` prefixes of matchers changed to `see`
* `seeBoolean`  matcher renamed to a short version `seeBool`
* `seeValueOf` renamed to `see`
* Removed `checksScenario` as it was deprecated in 2.0
* Removed `expectsThat` as it was deprecated in 2.0
* Removed `expectsTo` as it was deprecated in 2.0
* Deprecated `PHPKitchen\CodeSpecs\TesterInitialization` and will be removed in 4.0
* Deprecated `PHPKitchen\CodeSpecs\Specification\Specification` and will be removed in 4.0
* Deprecated `PHPKitchen\CodeSpecs\Specification\OldTester` and will be removed in 4.0

## 2.0.0

### New features
* Added `PHPKitchen\CodeSpecs\Specification\Specification` class that can be used as a base class for your tests
* All of the expectation methods moved to tester and renamed to begin with "see", like `$I->seeBoolean('dummy variable', true)->isFalse()` 
* Expectation methods now can accept name of the value as a first argument to print this name in error output

### BC breaks and deprecations
* Removed `and` from matchers
* Removed 'that' from matchers
* `expectsTahat`, `expectsTo`, `checksScenario` are deprecated and would be removed soon
* Removed Tester name personalization abilities
* Renamed Tester class to `PHPKitchen\CodeSpecs\Specification\Tester`
* `whenInvokedMethod` of "object" matcher is deprecated - use new `when` method.