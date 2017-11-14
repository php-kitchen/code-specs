# Runtime Matchers

Matchers being executed right where you define them, so, for example, if you define:
```php
$I->see($variable)
	->isNotEmpty()
	->isNotNull();
```  
once interpreter would reach code above it would start `see` matcher and execute `isNotEmpty` and then `isNotNull` expectations.

To have an ability to prepare a set of typical expectations that you can reuse sever times, without a need to re-define expectation, you can use Runtime Matchers functionality.
Runtime Matchers allow you to define a set of expectations and save it to a callable object that you can execute several times. For example, imagine following spec: 
```php
$I->lookAt('user data');
$I->seeArray($admin)
	->isNotEmpty()
	->hasKey('first_name');
	->hasKey('last_name');
	->hasKey('password');

$I->lookAt('user data');
$I->seeArray($member)
	->isNotEmpty()
	->hasKey('first_name');
	->hasKey('last_name');
	->hasKey('password');
```

With Runtime Matchers we can reduce such spec to:
```php
$matchUserDataHasValidStructure = $I->match('user data')
	->isArray()
	->isNotEmpty()
	->hasKey('first_name');
	->hasKey('last_name');
	->hasKey('password');

$matchUserDataHasValidStructure($admin);
$matchUserDataHasValidStructure($member);
``` 

In the example above we created runtime matcher, using `match` method. `match` method accepts only one argument - name of a variable that would be matched, like `lookAt`.
After `match` you need to specify a type of a variable, like with regular mathcers but except of `see` prefix you need to use `is`: `isBool`, `isString` etc. The only exception is mixed values - you need to use `isMixed` to define expectations for values without fixed type, example:

```php
$matchUserDataHasValidStructure = $I->match('request data')
	->isMixed()
	->isNotEmpty()
	->isNotNull();

$matchUserDataHasValidStructure($remoteRequestData);
$matchUserDataHasValidStructure($internalRequestData);
``` 