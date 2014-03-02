CakePHP 2 & Smarty 3
================

A simple CakePHP 2.x Plugin to get up and running with Smarty 3.  
I have tested this with CakePHP 2.4 and above, but should work easily with anything above 2.x.

## Installation

### Smarty 3
First we need to install Smarty 3, you can do this using composer.

Add the following to your composer.json

```json
{
	"config": {
		"vendor-dir" : "vendors"
	},
	"require": {
		"smarty/smarty": "3.1.*"
	}
}
```

Then in your root project directory, run:

    composer install

This will install smarty into your `vendors/smarty/smarty` directory.

### CakePHP View Helper Plugin

Finally, we have to install the CakePHP View Helper.

`cd` into `app/Plugin/` and run:

    git clone git@github.com:justanil/test-cakephp.git SmartyView

Put the following in your controller (can be `AppController.php` or any single controller `PagesController`)

    public $viewClass = 'SmartyView.Smarty';

Now for example, instead of cakephp looking for `home.ctp`, it will look for `home.tpl`

Set a var in a action (example `PagesController.php`):

```php
	// Remember to add this!
	$viewClass = "SmartyView.Smarty";

	public function home() {
		$this->set('fooVar', 'Woo!, it works!');
	}
```

Now in your template (e.g:`app/View/Pages/home.tpl`)

	{$fooVar}


