CakePHP 3-beta-3 & Smarty 3
================

A simple CakePHP 3.0-beta3 Plugin to get up and running with Smarty 3.
I have tested this with CakePHP 3-beta3.
Is a crap tricks but it's works.

Forked from https://github.com/Lakhman/CakePHP-2-Smarty-3-Helper-Plugin 
thanks Lakhman :)


## Installation

#### Smarty 3
First install Smarty 3, you can do this using composer.
Add the following to your `composer.json`

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

    $ curl -s "http://getcomposer.org/installer" | php
	$ php composer.phar install

This will install smarty into `vendors/smarty/smarty` directory.

You will need to create and give permissions to your cache and compile directories:

```
$ mkdir -p myCakeProject/tmp/smarty/
$ mkdir -p myCakeProject/tmp/smarty/cache
$ mkdir -p myCakeProject/tmp/smarty/compile
$ mkdir -p myCakeProject/tmp/smarty/config
$ chmod -R 0777 myCakeProject/tmp/smarty/
```

#### CakePHP View Helper Plugin

Next, we have to install the CakePHP View Helper.

go into your `myCakeProject/src/View` and copy SmartyView.php in this folder.

Finally, we have to tell CakePHP we want to use our SmartyView Plugin to render our view files.
You can put this in your `AppController.php` or within individual controllers `PagesController.php`

```php
/**
 * Change the default CakePHP viewClass to render through our Smarty Plugin
 * @var String
 */
	public $viewClass = 'Smarty';
```
---
##### Other tricks

Go to `myCakeProject/src/Template/Layout` and copy the default.ctp to default.tpl and rename default.ctp to default.ct_ [to see if it's work]. 

Open default.tpl and change all `<?= ` to `{` and ` ?>` to `}`

It's done.

After the test, rename all file .ctp to .tpl and it's works.

#### Basic Example

Add the following snippets in your cake application for a basic example:


```php
// `src/Controller/PagesController.php`
/**
 * Change the default CakePHP viewClass to render through our Smarty Plugin
 * @var String
 */
$viewClass = "Smarty";

/**
 * Render our `home.tpl` view
 */
public function smarty() {
	$this->set('smartyFooVar', 'Woo!, it works!');
}
```

```smarty
{*`src/Template/Pages/home.tpl`*}
{$smartyFooVar}
```

When you visit `/smarty`, you should see `Woo!, it works!`

---

#### More Examples

You can access all loaded CakePHP helpers in template files like so:

```smarty
{* Create and end form tags *}
{$form->create()}
{$form->end()}

{* import an element from app/View/Elements/filename.tpl *}
{$this->element('file_in_elements_directory')}

{* ouputs `The killer crept...` *}
{$text->truncate('The killer crept forward and tripped on the rug.', 22,
    ['ellipsis' => '...', 'exact' => false ]
)}

{* CakePHP Blocks also work *}
```

---

### License

	The MIT License (MIT)

	Copyright (c) 2014 justanil

	Permission is hereby granted, free of charge, to any person obtaining a copy of
	this software and associated documentation files (the "Software"), to deal in
	the Software without restriction, including without limitation the rights to
	use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
	the Software, and to permit persons to whom the Software is furnished to do so,
	subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all
	copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
	FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
	COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
	IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
	CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
