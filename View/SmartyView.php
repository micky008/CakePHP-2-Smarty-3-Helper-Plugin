<?php
/**
 * Place this file in App/View/SmartyView.php
 *
 * Create or return a existing SMARTY instance
 *
 * requires Smarty 3.x
 *
 * @link http://www.smarty.net/docs/en/installing.smarty.extended.tpl
 */
namespace App\View;
 
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Event\EventManager;
use Cake\View\View;
use Cake\Core\App;
use Cake\Core\Configure;
use Smarty;

define("VENDORS", TMP.'../vendor');

class SmartySingleton {

	static private $instance = null;

	private function __construct() {}
	private function __clone() {}
	private function __wakeup() {}

	static public function instance() {
		if (is_null(self::$instance)) {
		
			$smarty = new Smarty();

			$smarty->template_dir = APP . 'Template' . DS;

			$smarty->compile_dir = TMP . 'smarty' . DS . 'compile' . DS;
			$smarty->cache_dir = TMP . 'smarty' . DS . 'cache' . DS;

			$smarty->plugins_dir = array(
				APP . 'Plugin' . DS . 'SmartyView' . DS . 'Lib' . DS . 'Plugins',
				VENDORS . DS . 'smarty/smarty' . DS . 'libs' . DS . 'plugins'
			);

			$smarty->config_dir = TMP . 'smarty' . DS . 'config' . DS;
			$smarty->debug_tpl = APP . DS . 'Plugin' . DS . 'SmartyView' . DS . 'View' . DS . 'debug.tpl';

			// Other settings can be set here
			// $smarty->default_modifiers = array('escape:"html"');

			if (Configure::read('debug') == 2) {
				$smarty->debugging = true;
				$smarty->error_reporting = E_ALL & ~E_NOTICE;
				$smarty->compile_check = true;
				$smarty->force_compile = true;
			} else {
				$smarty->debugging = false;
				$smarty->error_reporting = null;
				$smarty->compile_check = false;
			}

			self::$instance = $smarty;
		}
		return self::$instance;
	}
}
class SmartyView extends View {

	public function __construct(Request $request = null, Response $response = null,
		EventManager $eventManager = null, array $viewOptions = []) {
		parent::__construct($request,$response,$eventManager,$viewOptions);
		$this->Smarty = SmartySingleton::instance();
		$this->_ext= '.tpl';
	}

/**
 * Renders and returns output for given view filename with its
 * array of data (using smarty), also handles parent/extended views.
 *
 * @param string $viewFile Filename of the view
 * @param array $data Data to include in rendered view. If empty the current View::$viewVars will be used.
 * @return string Rendered output
 */
protected function _render($viewFile, $data = array()) {
		
		if (stristr($viewFile,'.ctp') === 'ctp') {
			return parent::_render($viewFile, $data);
		}
		
		if (empty($data)) {
			$data = $this->viewVars;
		}
		$this->_current = $viewFile;
		$initialBlocks = count($this->Blocks->unclosed());

		$this->dispatchEvent('View.beforeRenderFile', [$viewFile]);

		foreach ($data as $key => $value) {
			if (!is_object($key)) {
				$this->Smarty->assign($key, $value);
			}
		}

		$helpers = $this->normalizeObjectArray($this->helpers);

		foreach ($helpers as $name => $properties) {
			list($plugin, $class) = pluginSplit($properties['class']);
			$this->{$class} = $this->Helpers->load($properties['class'], $properties['settings']);
			$this->Smarty->assignByRef(strtolower($name), $this->{$class});
		}
		
		
		$this->Smarty->assignByRef('this', $this);
		$content = $this->Smarty->fetch($viewFile);

		$afterEvent = $this->dispatchEvent('View.afterRenderFile', [$viewFile, $content]);
		if (isset($afterEvent->result)) {
			$content = $afterEvent->result;
		}

		if (isset($this->_parents[$viewFile])) {
			$this->_stack[] = $this->fetch('content');
			$this->assign('content', $content);

			$content = $this->_render($this->_parents[$viewFile]);
			$this->assign('content', array_pop($this->_stack));
		}

		$remainingBlocks = count($this->Blocks->unclosed());

		if ($initialBlocks !== $remainingBlocks) {
			throw new LogicException(sprintf(
				'The "%s" block was left open. Blocks are not allowed to cross files.',
				$this->Blocks->active()
			));
		}
		return $content;
	}
	
	private function normalizeObjectArray($objects) {
		$normal = array();
		foreach ($objects as $i => $objectName) {
			$options = array();
			if (!is_int($i)) {
				$options = (array)$objectName;
				$objectName = $i;
			}
			list(, $name) = pluginSplit($objectName);
			$normal[$name] = array('class' => $objectName, 'settings' => $options);
		}
		return $normal;
	}
	
	
	
}
