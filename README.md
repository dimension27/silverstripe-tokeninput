Provides the ability to use Jquery's Tokeninput (see http://loopj.com/jquery-tokeninput/ ) within Silverstripe.

# Usage

```php
    $field = new TokenInputField(
		'MyFieldName', 
		'My field label', 
		TokenInputField::getDataFromFlatArray(array('Foo', 'Bar'))
	));
```

# Limitations

Currently separate id and name values are not supported - if you need this functionality please clone, 
fix the issue and submit a pull request and we'll gladly put it in :) 