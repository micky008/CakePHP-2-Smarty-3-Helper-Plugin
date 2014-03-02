test cakephp
================

first use composer, add the following

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

then cd into `app/Plugin/` and run:

    git clone git@github.com:justanil/test-cakephp.git SmartyView

then in your controller (can be app controler or any single controller)

Place the following

    public $viewClass = 'SmartyView.Smarty';

Now for example, instead of cakephp looking for `home.ctp`, it will look for `home.tpl`

Set a var in a action:

```php
	public function home() {
		$this->set('mySmartyVar', 'wooo!, it works!');
	}
```

Now in your template (e.g:`app/View/Pages/home.tpl`)

	{$mySmartyVar}


