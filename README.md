CakePHP 2 & Smarty 3
================

A simple CakePHP 2.x Plugin to get up and running with Smarty 3.

I have tested this with CakePHP 2.4 and above, but should work with little modification with anything above 2.x.

## Installation

#### Smarty 3
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

This will install smarty into `vendors/smarty/smarty` directory.

#### CakePHP View Helper Plugin

Finally, we have to install the CakePHP View Helper.

`cd` into your `app/Plugin/` and run:

    git clone git@github.com:justanil/test-cakephp.git SmartyView

Put the following in your controller (can be `AppController.php` to use Smarty application wide, or any other controller `PagesController.php`)

	// Change the viewClass to SmartyView.Smarty
    public $viewClass = 'SmartyView.Smarty';

Now, instead of CakePHP looking for `home.ctp`, it will look for `home.tpl`

Basic Test: (example `PagesController.php`):

```php
	// Remember to add this!
	$viewClass = "SmartyView.Smarty";

	public function home() {
		$this->set('fooVar', 'Woo!, it works!');
	}
```

Now in your template (e.g:`app/View/Pages/home.tpl`)

	{$fooVar}

When you visit `/home`, you should see `Woo!, it works!`.

