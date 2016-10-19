# Personalization

## Changing tester name

You can change tester name just for fun. For example you can name your tester as "Antonio". To do so, you just need to implement method "getTesterName", that will return custom tester name, in your test class.
For example:

```php
/**
 * @inheritdoc
 * @override
 */
protected function getTesterName() {
    return 'Antonio';
}
```

Once you do this you start to receive error messages from tester begins with "Antonio expects that ".