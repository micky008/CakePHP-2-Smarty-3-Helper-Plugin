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

Next, we have to install the CakePHP View Helper.

`cd` into your `app/Plugin/` and run:

    git clone git@github.com:justanil/test-cakephp.git SmartyView

Tell CakePHP to load our plugin (`app/Config/bootstrap.php`)

```php
CakePlugin::load('SmartyView');
```

Finally, we have to tell CakePHP we want to use our SmartyView Plugin to render our view files.
You can put this in your `AppController.php` or in individual controllers `PagesController.php`

```php
/**
 * Change the default CakePHP viewClass to render through our Smarty Plugin
 * @var String
 */
public $viewClass = 'SmartyView.Smarty';
```
---

#### Example

Add the following snippets in your cake application for a basic example:


`app/Config/routes.php`:

```php
Router::connect('/smarty', array('controller' => 'pages', 'action' => 'smarty'));
```

`app/Controller/PagesController.php`:

```php
/**
 * Change the default CakePHP viewClass to render through our Smarty Plugin
 * @var String
 */
$viewClass = "SmartyView.Smarty";

/**
 * Render our `home.tpl` view
 */
public function smarty() {
	$this->set('smartyFooVar', 'Woo!, it works!');
}
```

`app/View/Pages/smarty.tpl`

	{$smartyFooVar}

When you visit `/smarty`, you should see `Woo!, it works!`.

