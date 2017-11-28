# Codeception integration

CodeSpecs works in Codeception unit tests the same way as in PHPUnit tests even with the same interface.

To enable CodeSpecs module you just need to add following line to enabled modules:
```yaml
- \PHPKitchen\CodeSpecs\Integration\Codeception\CodeSpecs
```

Example of unit tests suite configuration:
```yaml
suites:
    Unit:
        path: Unit
        actor: UnitTester
        modules:
            enabled:
                - Asserts
                - \Helper\Unit
                - \PHPKitchen\CodeSpecs\Integration\Codeception\CodeSpecs
```

**Note**: don't forget to re-build helpers after modules configuration (`codecept build`).