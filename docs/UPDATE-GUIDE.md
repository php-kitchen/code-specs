## 3.0.0

* Replace all of the `DeKey\Tester` ocurances to `PHPKitchen\CodeSpecs`
* Change `PHPKitchen\CodeSpecs\TesterInitialization` to `PHPKitchen\CodeSpecs\Mixin\TesterInitialization` in all classes if you use mixin to get tester. 
* Change base class `PHPKitchen\CodeSpecs\Specification\Specification` to `\PHPKitchen\CodeSpecs\Base\Specification` in all of the tests if you extend your tests from base specification class.
* Replace all of the `seeThat` ocurances to `see`
* Replace all of the `seeThatBoolean` ocurances to `seeBool`
* Replace all of the `seeThatValueOf` ocurances to `see`
* In case you passed variable name as a first argument to `seeThat*` expectations, move variable name to a new method `lookAt`

