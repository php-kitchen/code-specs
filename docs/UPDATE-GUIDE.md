## 4.0.0

* Replace all of the `use PHPKitchen\CodeSpecsCore\Contract\TestGuy;` occurrences to `use PHPKitchen\CodeSpecs\Contract\TestGuy;`
* In case you used some of core files, replace all of the `use PHPKitchen\CodeSpecsCore` occurrences to `use PHPKitchen\CodeSpecs`

## 3.0.0

* Replace all of the `DeKey\Tester` occurrences to `PHPKitchen\CodeSpecs`
* Change `PHPKitchen\CodeSpecs\TesterInitialization` to `PHPKitchen\CodeSpecs\Mixin\TesterInitialization` in all classes if you use mixin to get tester. 
* Change base class `PHPKitchen\CodeSpecs\Specification\Specification` to `\PHPKitchen\CodeSpecs\Base\Specification` in all of the tests if you extend your tests from base specification class.
* Replace all of the `see` occurrences to `see`
* Replace all of the `seeBoolean` occurrences to `seeBool`
* Replace all of the `seeValueOf` occurrences to `see`
* In case you passed variable name as a first argument to `see*` expectations, move variable name to a new method `lookAt`

