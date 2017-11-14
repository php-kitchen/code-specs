# Wait directive usage

In the following displayed basic usage of "Wait" directive. This directive stop execution of a test for a specified period of time.

```php
/**
 * @test
 */
public function callBackSpec() {
        $I = $this->tester;
        $I->describe('process of testing values without any requirements for type-specific expectations');

        RemoteService::requestData();
        
        $I->wait(35)->seconds(); // stops execution for 35 seconds

        $I->expectThat('remote service returned requested data');
        $I->seeArray(RemoteService::getReuestedData())
            ->isNotEmpty()
            ->isNotNull()
            ->hasKey('success);
}
```