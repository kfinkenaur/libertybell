<?php

$MOJOConfiguration = '{
    "userName": "creativeone247@gmail.com",
    "userPassword": "$P$BjjijyOA3DK471GBEovpLiobjtikJ.\/",
    "userEmail": "creativeone247@gmail.com",
    "siteUrl": "http:\/\/www.mainefabricshop.com\/",
    "blogTitle": "My great Wordpress blog",
    "process": "install",
    "theme": false,
    "authTokenField": "Wd4GxtriWM2qZPGl",
    "authToken": "eb220e6ddee778b31f339e92918b12bc",
    "authSalt": "oIeXG7IElyo6QvIN85lgHAiAoNdIcX8sT2AqgEhmBohWFxCGvgt3hcqdgyqJIDgM"
}';

// MOJOConfiguration

/**
 * Provides us with some easy-to-work-with stuff while still being able to jump the stack
 * and have clean flow control.
 **/
class MOJOInstallException extends Exception {

/**
 * [placeholder description]
 *
 * @param [type] $message [placeholder]
 * @param [type] $situation [placeholder]
 * @return [type]
 */
	public function __construct($message, $situation = 'unknown') {
		parent::__construct($message);

		$this->message = $message;
		$this->situation = $situation;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function getSituation() {
		return $this->situation;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function format() {
		return Array(
			'situation' => $this->situation,
			'errorMessage' => $this->message,
			'version' => phpversion(),
			'status' => 'error'
		);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function __toString() {
		return $this->message . ' while ' . $this->situation . ' at ' . $this->getTraceAsString();
	}
}
/**
 * [MOJOInstallFailedException description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOInstallFailedException extends MOJOInstallException {
}
/**
 * Signals that the install should be continued, but
 * we can't do any more in this execution due to time limits.
 * */
class MOJOContinueException extends MOJOInstallException {
}
/**
 * [MOJOControlInverter description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOControlInverter {

/**
 * [placeholder description]
 *
 * @param [type] $function [placeholder]
 * @param [type] $arguments [placeholder]
 * @return [type]
 */
	public function __call($function, $arguments) {
		if (strpos($function, 'mockable_') === 0) {
			$function = substr($function, 9);
		}

		if (function_exists($function)) {
			return call_user_func_array($function, $arguments);
		}

		throw new Exception("Call to unknown function {$function} attempted");
	}

	// Would read 'new', but that's reserved.

/**
 * [placeholder description]
 *
 * @param [type] $class [placeholder]
 * @param [type] $arguments [placeholder]
 * @return [type]
 */
	public function instantiate($class, $arguments = array()) {
		$reflection = new ReflectionClass($class);
		return $reflection->newInstanceArgs($arguments);
	}
}
/**
 * [MOJOOutput description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOOutput extends MOJOControlInverter {

	public static $softFailures = Array();

	public static $logs = Array();

	public static $step = null;

	public static $cleanShutdown = false;

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public static function reset() {
		self::$softFailures = Array();
		self::$logs = Array();
		self::$step = null;
		self::$cleanShutdown = false;
	}

/**
 * [placeholder description]
 *
 * @param [type] $exception [placeholder]
 * @return [type]
 */
	public static function formatException($exception) {
		if ($exception instanceof MOJOInstallFailedException) {
			$situation = $exception->getSituation();
		} elseif (self::$step) {
			$situation = self::$step;
		} else {
			$situation = $exception->getFile() . ':' . $exception->getLine();
		}

		if ($exception instanceof MOJOContinueException) {
			return Array(
				'status' => 'continue',
				'continue' => true,
				'situation' => $situation,
				'logs' => self::$logs,
				'softFailures' => self::$softFailures
			);
		}

		return Array(
			'status' => 'exception',
			'version' => phpversion(),
			'situation' => $situation,
			'step' => self::$step ? self::$step : 'other',
			'message' => $exception->getMessage(),
			'class' => get_class($exception),
			'trace' => $exception->getTraceAsString(),
			'file' => $exception->getFile(),
			'line' => $exception->getLine(),
			'server' => $_SERVER,
			'post' => $_POST,
			'get' => $_GET,
			'softFailures' => self::$softFailures,
			'logs' => self::$logs,
			'ini' => ini_get_all(),
			'extensions' => get_loaded_extensions()
		);
	}

/**
 * Formats a success response for transmission
 * Formats a success response for transmission
 *
 * @author [placeholder]
 * @return [type]
 */
	public static function formatSuccess() {
		return Array(
			'status' => 'success',
			'logs' => self::$logs,
			'softFailures' => self::$softFailures,
			'ini' => ini_get_all(),
			'extensions' => get_loaded_extensions()
		);
	}

/**
 * [placeholder description]
 *
 * @param [type] $message [placeholder]
 * @return [type]
 */
	public static function log($message) {
		self::$logs[] = $message;
	}

/**
 * [placeholder description]
 *
 * @param [type] $message [placeholder]
 * @return [type]
 */
	public static function addSoftFailure($message) {
		self::$softFailures[] = $message;
		self::log($message);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public static function compact() {
		return Array(
			'logs' => self::$logs,
			'softFailures' => self::$softFailures
		);
	}

/**
 * [placeholder description]
 *
 * @param [type] $compactedData [placeholder]
 * @return [type]
 */
	public static function insert($compactedData) {
		if (!empty($compactedData['logs'])) {
			self::$logs = $compactedData['logs'];
		}

		if (!empty($compactedData['softFailures'])) {
			self::$softFailures = $compactedData['softFailures'];
		}
	}

/**
 * [placeholder description]
 *
 * @param [type] $errno [placeholder]
 * @param [type] $errstr [placeholder]
 * @param [type] $errfile [placeholder]
 * @param [type] $errline [placeholder]
 * @param [type] $errcontext [placeholder]
 * @return [type]
 */
	public static function error_handler($errno, $errstr, $errfile, $errline, $errcontext) {
		$ignorableErrors = Array(
			E_STRICT,
			E_DEPRECATED
		);

		if (in_array($errno, $ignorableErrors))
			return;

		$exception = new Exception('Intentionally Blank');
		$trace = $exception->getTraceAsString();

		$errorInfo = compact('errno', 'errstr', 'errfile', 'errline', 'trace');

		if (!@json_encode($errorInfo)) {
			$errorInfo = @serialize($errorInfo);
		}

		if (self::$step) {
			self::log(array('Hit an error inside step ' . self::$step => $errorInfo));
		} else {
			self::log(array('Hit an error outside of a step.  Error info:' => $errorInfo));
		}
	}

/**
 * [placeholder description]
 *
 * @param [type] $step [placeholder]
 * @return [type]
 */
	public static function logCurrentStep($step) {
		self::$step = $step;
		self::$logs[] = "Starting step $step";
		ob_start();
	}

/**
 * [placeholder description]
 *
 * @param [type] $step [placeholder]
 * @return [type]
 */
	public static function completedCurrentStep($step) {
		$output = ob_get_clean();
		$message = "Completed step $step.";

		if ($output) {
			$message .= "  Output was: " . $output;
		}

		self::$logs[] = $message;
		self::$step = null;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public static function initiateCleanShutdown() {
		self::$cleanShutdown = true;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public static function shutdown() {
		if (self::$cleanShutdown) {
			return;
		}

		self::$cleanShutdown = true;

		if (!empty(self::$step)) {
			self::$logs[] = "Died in current step.  Output was: " . ob_get_clean();
		}

		$lastError = error_get_last();

		self::finish(Array(
			'status' => 'Fatal Error',
			'situation' => 'unknown',
			'step' => self::$step ? self::$step : 'unknown',
			'version' => phpversion(),
			'file' => $lastError['file'],
			'line' => $lastError['line'],
			'message' => $lastError['message'],
			'type' => $lastError['type'],
			'logs' => self::$logs,
			'softFailures' => self::$softFailures,
			'ini' => ini_get_all(),
			'extensions' => get_loaded_extensions()
		));
	}

/**
 * [placeholder description]
 *
 * @param [type] $output [placeholder]
 * @return [type]
 */
	public static function finish($output) {
		self::$cleanShutdown = true;

		echo MOJOMarshaller::marshall($output);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected static function _getPhpEnvironment() {
		$extensions = get_loaded_extensions();
		$extensionData = Array();

		foreach ($extensions as $extension) {
			$extensionData[$extension] = ini_get_all($extension);
		}

		return Array(
			'ini' => ini_get_all(),
			'extensions' => $extensionData
		);
	}
}
/**
 * [MOJOMarshaller description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOMarshaller {

	protected static $_marshaller = null;

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public static function determineMarshalling() {
		if (!is_null(self::$_marshaller)) {
			return;
		}

		if (function_exists('json_encode')) {
			self::$_marshaller = 'json';
		} else {
			self::$_marshaller = 'serialize';
		}
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public static function reset() {
		self::$_marshaller = null;
	}

/**
 * [placeholder description]
 *
 * @param [type] $data [placeholder]
 * @return [type]
 */
	public static function marshall($data) {
		self::determineMarshalling();

		if (self::$_marshaller == 'json') {
			if (version_compare(phpversion(), '5.4.0', '>=')) {
				return json_encode($data, JSON_PRETTY_PRINT);
			} else {
				return json_encode($data);
			}
		} else {
			return serialize($data);
		}
	}

/**
 * [placeholder description]
 *
 * @param [type] $data [placeholder]
 * @return [type]
 */
	public static function unMarshall($data) {
		self::determineMarshalling();

		if (empty($data)) {
			return Array();
		}

		if ($data[0] == '{' || $data[0] == '[') {
			if (function_exists('json_decode')) {
				return json_decode($data, true);
			} else {
				trigger_error("Could not unmarshall JSON'd data: function json_decode does not exist!");
				return Array();
			}
		} elseif ($data[0] == 'a' && $data[1] == ':') {
			return unserialize($data);
		} else {
			return unserialize($data);
		}
	}
}
/**
 * [MOJOConfiguration description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOConfiguration extends MOJOControlInverter implements ArrayAccess {

	protected $_configuration = array();

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function __construct() {
		$this->loadConfiguration();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function loadConfiguration() {
		global $MOJOConfiguration;

		$this->_configuration = $this->mockable_json_decode($MOJOConfiguration, true);
		$this->validateConfiguration();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function validateConfiguration() {
		// This is more intended to determine that we read the right file, more than anything else.
		foreach (MOJOProcessInfo::$requiredConfigurationOptions as $option) {
			if (!isset($this->_configuration[$option]) && !is_array($this->_configuration[$option])) {
				throw new MOJOInstallFailedException("Missing configuration option {$option}", "validating configuration");
			}
		}
	}

/**
 * [placeholder description]
 *
 * @param [type] $offset [placeholder]
 * @return [type]
 */
	public function offsetExists($offset) {
		return isset($this->_configuration[$offset]);
	}

/**
 * [placeholder description]
 *
 * @param [type] $offset [placeholder]
 * @return [type]
 */
	public function offsetGet($offset) {
		if (!$this->offsetExists($offset)) {
			trigger_error("Offset not found: " . $offset);
			return null;
		}

		return $this->_configuration[$offset];
	}

/**
 * [placeholder description]
 *
 * @param [type] $offset [placeholder]
 * @param [type] $value [placeholder]
 * @return [type]
 */
	public function offsetSet($offset, $value) {
		trigger_error("offsetSet not allowed");
	}

/**
 * [placeholder description]
 *
 * @param [type] $offset [placeholder]
 * @return [type]
 */
	public function offsetUnset($offset) {
		trigger_error("offsetUnset not allowed");
	}
}
/**
 * [MOJOTimer description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOTimer extends MOJOControlInverter {

	public $startTime = null;

	public $timeLimit = null;

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function __construct() {
		$this->startTime = $this->mockable_microtime(true);
		$this->timeLimit = $this->mockable_ini_get('max_execution_time');

		if (empty($this->timeLimit) || $this->timeLimit > 60) {
			$this->timeLimit = 60;
		}
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function maybeShutDown() {
		$now = $this->mockable_microtime(true);

		if ($now > $this->startTime + (0.8 * $this->timeLimit)) {
			return true;
		}

		return false;
	}
}
/**
 * Future: Use this to override default content
 * function wp_install_defaults($user_id) {}
 **/
/**
 * Future: Use this to override initial email
 * function wp_new_blog_notification($blog_title, $blog_url, $user_id, $password) {}
 **/

/**
 * You may notice that this is not typical camel-case.  What's with screwing the conventions?
 * MOJO is to be yelled, at the top of your lungs.
 * That's why.
 *
 * Seriously though, that's really it.  It's therapeutic.  Especially if you're that 0.5% of users
 * who this fails for.  I apologize in advance if that's you - checking your PHP and mysql settings.
 *
 * Also, if you're experienced, send us some technical details about the failure mode and we'll get
 * on troubleshooting ASAP.  I'm working on a bugs-for-beer initiative, hopefully the suits will like it.
 *
 * Only the constructor and execute* functions should be called outside of unit tests.
 **/
class MOJOProcess extends MOJOControlInverter {

	protected $_errors = Array();

	protected $_softFailures = Array();

	protected $normalShutdown = false;

	public $allowedActions = array(
		'initializeDatabase',
		'populateDatabase'
	);

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function __construct() {
		$this->initialize();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function initialize() {
		$this->_setErrorHandling();
		$this->_setPhpVariables();
		$this->_configure();
		$this->_authenticate();
		$this->_makeIterator();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _setErrorHandling() {
		$this->mockable_set_error_handler(Array('MOJOOutput', 'error_handler'));
		$this->_registerShutdownFunction();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _setPhpVariables() {
		$this->mockable_ini_set('html_errors', false);
		$this->mockable_ini_set('error_prepend_string', 'PHP_ERROR');
		$this->mockable_ini_set('error_append_string', 'END_PHP_ERROR');
		$this->mockable_ini_set('error_log', '/dev/null');
		$this->mockable_ini_set('display_errors', 0);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _configure() {
		$this->configuration = $this->instantiate('MOJOConfiguration');
		$this->timer = $this->instantiate('MOJOTimer');
		$this->state = $this->instantiate('MOJOState', Array($this->configuration));
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _authenticate() {
		$authTokenField = $this->configuration['authTokenField'];
		if (empty($_POST[$authTokenField])) {
			$this->_authFailed();
		}

		// On configuration error, crash rather than open a hole.
		if (empty($this->configuration['authToken']) || empty($this->configuration['authSalt'])) {
			$this->_authFailed();
		}

		$token = $_POST[$authTokenField];

		if (!is_string($token)) {
			$this->_authFailed();
		}

		// See here for more info - it's one of my favorite crypto techniques.
		// http://www.youtube.com/watch?v=BROWqjuTM0g
		for ($i = 0; $i < 5; $i++) {
			$token .= $token . $this->configuration['authSalt'];
			$token = md5($token);
		}

		if ($token !== $this->configuration['authToken']) {
			$this->mockable_sleep(15);
			$this->_authFailed();
		}
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _makeIterator() {
		$this->_iterator = $this->instantiate(MOJOProcessInfo::$mainProcessHandler, array($this->state, $this->configuration));
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _authFailed() {
		MOJOOutput::initiateCleanShutdown();
		echo json_encode(Array(
			'status' => 'failed',
			'situation' => 'authentication'
		));
		$this->mockable_die();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _registerShutdownFunction() {
		$this->mockable_register_shutdown_function(array($this, 'shutdown'));
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function shutdown() {
		MOJOOutput::shutdown();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function execute() {
		MOJOOutput::log("Starting up.");
		$result = null;

		try {
			$this->executeSteps($this->_iterator);
		} catch (Exception $exception) {
			$this->maybeReThrow($exception);
			$result = MOJOOutput::formatException($exception);
		}

		if (empty($result)) {
			$result = MOJOOutput::formatSuccess();
		}

		MOJOOutput::initiateCleanShutdown();
		MOJOOutput::log("Shut down.");
		MOJOOutput::finish($result);
	}

/**
 * [placeholder description]
 *
 * @param [type] $iterator [placeholder]
 * @return [type]
 */
	public function executeSteps($iterator) {
		foreach ($iterator as $step => $stepData) {

			$iterator->runStep();

			if (!$this->state->valid()) {
				break;
			}

			if ($this->timer->maybeShutDown()) {
				MOJOOutput::log("Approaching the time limit; shutting down.");
				throw new MOJOContinueException("Approaching the time limit");
			}
		}
	}

/**
 * [placeholder description]
 *
 * @param [type] $e [placeholder]
 * @return [type]
 */
	public function maybeReThrow($e) {
		return false;
	}
}
/**
 * This is a decent first-run at it, but I'm tired and behind deadline.
 * Second iteration needs to do references
 * */
class MOJOState extends MOJOControlInverter {

	protected $_state = array();

	protected $_steps = array();

	protected $_needle = 0;

/**
 * [placeholder description]
 *
 * @param [type] $configuration [placeholder]
 * @param [type] $stateFile [placeholder]
 * @return [type]
 */
	public function __construct($configuration, $stateFile = null) {
		$this->_configuration = $configuration;
		$this->_stateFile = $stateFile;

		$this->_loadSteps();
		$this->_loadState();
		$this->_startUp();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _loadSteps() {
		if ($this->_configuration['process'] == "install") {
			$this->_steps = MOJOProcessInfo::$installSteps;
		} elseif ($this->_configuration['process'] == "upgrade") {
			$this->_steps = MOJOProcessInfo::$upgradeSteps;
		}
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _file() {
		if (empty($this->_stateFile)) {
			$pathInfo = $this->mockable_pathinfo(__FILE__);

			if (!empty($this->_configuration['root'])) {
				$currentDirectory = $this->_configuration['root'] . '/';
			} else {
				$currentDirectory = $this->mockable_dirname(__FILE__);
			}

			$currentDirectory = $this->mockable_str_replace('\\', '/', $currentDirectory);
			$currentDirectory = $this->mockable_str_replace('//', '/', $currentDirectory);

			$this->_stateFile = $currentDirectory . '/' . $pathInfo['filename'] . '.state.json';
		}

		return $this->_stateFile;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _loadState() {
		if (!file_exists($this->_file())) {
			$this->_state = array();
			return;
		}

		$contents = $this->mockable_file_get_contents($this->_file());

		if (empty($contents)) {
			$this->_state = Array();
			return;
		}

		$this->_state = MOJOMarshaller::unMarshall($contents);
		if (!empty($this->_state['output'])) {
			MOJOOutput::insert($this->_state['output']);
			MOJOOutput::log("Continuing from previous execution!");
		}
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function saveState() {
		$this->_state['output'] = MOJOOutput::compact();

		$this->mockable_file_put_contents($this->_file(), MOJOMarshaller::marshall($this->_state));
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	protected function _startUp() {
		if (empty($this->_state['steps'])) {
			$this->_state['steps'] = Array();
		}

		if (empty($this->_state['failures'])) {
			$this->_state['failures'] = Array();
		}

		if (empty($this->_state['skip'])) {
			$this->_state['skip'] = Array();
		}

		$stateKeys = array_keys($this->_state['steps']);
		$completedStateKeys = array_filter($stateKeys);
		$this->_remaining = $this->array_diff($this->_steps, $completedStateKeys);
	}

/**
 * [placeholder description]
 *
 * @param [type] $key [placeholder]
 * @return [type]
 */
	public function maybeSkip($key) {
		if (in_array($key, $this->_state['skip'], true)) {
			return true;
		}

		return false;
	}

/**
 * [placeholder description]
 *
 * @param [type] $key [placeholder]
 * @param [type] $value [placeholder]
 * @return [type]
 */
	public function skip($key, $value = "completed") {
		$this->_state['skip'][$key] = $value;

		$this->saveState();
	}

/**
 * [placeholder description]
 *
 * @param [type] $key [placeholder]
 * @return [type]
 */
	public function unskip($key) {
		$position = array_search($key, $this->_state['skip'], true);

		if ($position == false) {
			unset($this->_state['skip'][$position]);
		}

		$this->saveState();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function complete() {
		array_shift($this->_remaining);
		$this->saveState();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function rewind() {
		// MVP strikes again.  No transaction for you.
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function next() {
		if (!$this->valid()) {
			return false;
		}

		return current($this->_remaining);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function valid() {
		if (!empty($this->_remaining)) {
			return true;
		}

		return false;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function current() {
		if (!$this->valid()) {
			return false;
		}

		$step = $this->_remaining[0];

		return $step;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function key() {
		return $this->current();
	}

}
/**
 * [MOJOBaseHandler description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOBaseHandler extends MOJOControlInverter implements Iterator {

	protected $_state = null;

	protected $_configuration = null;

	protected $_themeHandler = null;

	protected $_pluginHandler = null;

	protected $_childDefinitions = null;

/**
 * [placeholder description]
 *
 * @param [type] $state [placeholder]
 * @param [type] $configuration [placeholder]
 * @return [type]
 */
	public function __construct($state, $configuration) {
		$this->_state = $state;
		$this->_configuration = $configuration;
		$this->_childDefinitions = MOJOProcessInfo::$childProcessDefinitions;
	}

/**
 * [placeholder description]
 *
 * @param [type] $step [placeholder]
 * @return [type]
 */
	protected function _childDefinition($step) {
		foreach ($this->_childDefinitions as $prefix => $classInfo) {
			if (strpos($step, $prefix . '.') === 0) {
				return $this->_childDefinitions[$prefix];
			}
		}

		return false;
	}

/**
 * [placeholder description]
 *
 * @param [type] $step [placeholder]
 * @return [type]
 */
	protected function _getHandlerFor($step) {
		$childDefinition = $this->_childDefinition($step);

		if (empty($childDefinition)) {
			return $this;
		}

		$classVar = $childDefinition[0];
		$className = $childDefinition[1];

		if ($className == $this->mockable_get_class($this)) {
			return $this;
		}

		if (empty($this->$classVar)) {
			$this->$classVar = new $className($this->_state, $this->_configuration);
		}

		return $this->$classVar;
	}

/**
 * [placeholder description]
 *
 * @param [type] $step [placeholder]
 * @return [type]
 */
	public function exec($step) {
		$parts = explode('.', $step);
		$step = end($parts);

		$this->{$step}();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function rewind() {
		$this->_state->rewind();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function next() {
		return $this->_state->next();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function valid() {
		return $this->_state->valid();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function current() {
		if (!$this->_state->valid()) {
			return null;
		}

		return $this->_state->current();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function runStep() {
		$step = $this->_state->current();

		MOJOOutput::logCurrentStep($step);

		$this->_getHandlerFor($step)->exec($step);

		MOJOOutput::completedCurrentStep($step);

		$this->_state->complete();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function key() {
		if (!$this->_state->valid()) {
			return null;
		}

		return $this->_state->current();
	}
}
//  Begin the CMS-specific stuff.  Below here is GPL.

/**
 * [MOJOProcessInfo description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOProcessInfo {

	public static $installSteps = array(
		'addWPDieHandler',
		'prepareForInstallationProcess',
		'checkRequiredFiles',
		'checkCoreCompatibility',
		'wp_check_mysql_version',
		'wp_cache_flush',
		'installDatabaseTables',
		'populate_options',
		'populate_roles',
		'setUpSiteOptions',
		'createAdminUser',
		'installDefaults',
		'flush_rewrite_rules',
		'wp_cache_flush',
		'theme.activate',
		'plugin.activateAll',
	);

	public static $upgradeSteps = array(
		'addWPDieHandler',
		'checkRequiredFiles',
		'wp_cache_flush',
		'pre_schema_upgrade',
		'installDatabaseTables',
		'upgrade_all',
		'wp_cache_flush',
		'plugin.upgrade',
		'theme.upgrade'
	);

	// Unimplemented/future.

	public static $multiSiteUpgradeSteps = array(
		'upgrade_network',
		'upgradeBlogVersions'
	);

	public static $requiredConfigurationOptions = Array(
		'theme',
		'process',

		'blogTitle',
		'siteUrl',
		'userEmail',
		'userName',
		'userPassword',
	);

	public static $requiredPHPVersion = '5.2.4';

	public static $requiredMySqlVersion = '5.0';

	public static $childProcessDefinitions = Array(
		'plugin' => Array('_pluginHandler', 'MOJOWordpressPluginHandler'),
		'theme' => Array('_themeHandler', 'MOJOWordpressThemeHandler')
	);

	public static $mainProcessHandler = 'MOJOWordpressHandler';
}
/**
 * [MOJOWordpressHandler description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOWordpressHandler extends MOJOBaseHandler {

	protected $_prefix = null;

	protected $_root = null;

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function prepareForInstallationProcess() {
		define( 'WP_INSTALLING', true );
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function addWPDieHandler() {
		global $wp_filter;

		$wp_filter = Array(
			'wp_die_handler' => Array(
				9999 => Array(
					'How do you catch a unique rabbit?  U NIQUE UP ON IT!  hahahahahaha' => Array(
						'function' => Array($this, 'specifyWPDieHandler'),
						'accepted_args' => 3
					)
				)
			)
		);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function specifyWPDieHandler() {
		return Array('MOJOWordpressHandler', 'wpDieHandler');
	}

/**
 * [placeholder description]
 *
 * @param [type] $error [placeholder]
 * @return [type]
 */
	public static function wpDieWithWPError($error) {
		$message = $error->get_error_message();
		$message = trim(strip_tags($message));

		if (MOJOOutput::$step) {
			$step = MOJOOutput::$step;
			MOJOOutput::log(array("Died in $step, via the wp_die handler:" => compact('message', 'title', 'args')));
		} else {
			MOJOOutput::log(array("Died by the Wordpress die handler with arguments:" => compact('message', 'title', 'args')));
		}

		MOJOOutput::finish(Array(
			'status' => 'error',
			'version' => phpversion(),
			'message' => $message,
			'situation' => 'native wordpress error',
			'logs' => MOJOOutput::$logs,
			'softFailures' => MOJOOutput::$softFailures
		));

		die();
	}

/**
 * [placeholder description]
 *
 * @param [type] $message [placeholder]
 * @param [type] $title [placeholder]
 * @param [type] $args [placeholder]
 * @return [type]
 */
	public static function wpDieHandler($message, $title, $args) {
		if (class_exists('WP_Error')) {
			if ($message instanceof WP_Error) {
				self::wpDieWithWPError($message);
			}
		}

		$message = trim(strip_tags($message));

		if (MOJOOutput::$step) {
			$step = MOJOOutput::$step;
			MOJOOutput::log(array("Died in $step, via the wp_die handler:" => compact('message', 'title', 'args')));
		} else {
			MOJOOutput::log(array("Died by the Wordpress die handler with arguments:" => compact('message', 'title', 'args')));
		}

		MOJOOutput::finish(Array(
			'status' => 'Died in the wp_die handler',
			'version' => phpversion(),
			'situation' => MOJOOutput::$step ? MOJOOutput::$step : 'other',
			'message' => $message,
			'logs' => MOJOOutput::$logs,
			'softFailures' => MOJOOutput::$softFailures
		));

		die();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function checkRequiredFiles() {
		$exception = new MOJOInstallFailedException("Could not find core files required to perform the installation.", "checking file paths", "ours");

		if (empty($this->_configuration['root'])) {
			$this->_root = dirname(__FILE__) . '/';
		}

		if (!@include_once($this->_root . 'wp-load.php'))
			throw new MOJOInstallFailedException("Could not find core files required to perform the installation.", "checking file path " . $this->_root . 'wp-load.php');

		if (!@include_once(ABSPATH . 'wp-admin/includes/upgrade.php'))
			throw new MOJOInstallFailedException("Could not find core files required to perform the installation.", "checking file path " . $this->_root . 'wp-admin/includes/upgrade.php');

		if (!@include_once(ABSPATH . 'wp-admin/includes/plugin.php'))
			throw new MOJOInstallFailedException("Could not find core files required to perform the installation.", "checking file path " . $this->_root . 'wp-admin/includes/plugin.php');

		if (!@include_once(ABSPATH . 'wp-includes/wp-db.php'))
			throw new MOJOInstallFailedException("Could not find core files required to perform the installation.", "checking file path " . $this->_root . 'wp-includes/wp-db.php');
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function setUpDatabase() {
		global $wpdb;

		$wpdb->show_errors = false;
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function checkCoreCompatibility() {
		global $wpdb;
		$errors = Array();

		define('WP_SITEURL', $this->_configuration['siteUrl']);
		$_SERVER['HTTP_HOST'] = parse_url($this->_configuration['siteUrl'], PHP_URL_HOST);

		$this->phpVersion = phpversion();
		$this->mySqlVersion = $wpdb->db_version();

		if (!version_compare($this->phpVersion, MOJOProcessInfo::$requiredPHPVersion, '>=')) {
			$errors[] = "Incompatible PHP version: Version {$this->phpVersion} is present, but version " . MOJOProcessInfo::$requiredPhpVersion . " is required";
		}

		if (!version_compare($this->mySqlVersion, MOJOProcessInfo::$requiredMySqlVersion, '>=')) {
			$errors[] = "Incompatible MySQL version: Version {$this->mySqlVersion} is present, but version " . MOJOProcessInfo::$requiredMySqlVersion . " is required";
		}

		if (empty($wpdb->base_prefix)) {
			$errors[] = "Configuration is empty";
		}

		$errors = implode(', ', $errors);

		if ($errors) {
			throw new MOJOInstallFailedException($errors, "checking server compatibility", "server_configuration");
		}
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function installDatabaseTables() {
		$alterations = dbDelta( 'all' );
		$alterations = "Applied database changes: \n" . implode("\n", $alterations);

		MOJOOutput::log($alterations);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function setUpSiteOptions() {
		$this->mockable_update_option('blogname', $this->_configuration['blogTitle']);
		$this->mockable_add_option('admin_email', $this->_configuration['userEmail']);
		$this->mockable_update_option('blog_public', true);
		$this->mockable_update_option('siteurl', $this->_configuration['siteUrl']);
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function createAdminUser() {
		global $wpdb;

		$user_id = username_exists($this->_configuration['userName']);

		if (is_null($user_id)) {
			$user_password = wp_generate_password(256, false);
			$user_id = wp_create_user($this->_configuration['userName'], $user_password, $this->_configuration['userEmail']);
		}

		$user = $this->instantiate('WP_User', Array($user_id));
		$user->set_role('administrator');

		$passwordUpdate = Array(
			'user_pass' => $this->_configuration['userPassword']
		);

		$wpdb->update($wpdb->users, $passwordUpdate, array('ID' => $user_id));

		MOJOOutput::log("created admin user " . json_encode(Array('user_id' => $user_id, 'update' => $passwordUpdate, 'userName' => $this->_configuration['userName'])));

		$this->mockable_wp_cache_flush();
	}

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function installDefaults() {
		$this->mockable_wp_install_defaults(0);
	}
}
/**
 * [MOJOWordpressPluginHandler description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOWordpressPluginHandler extends MOJOBaseHandler {

	protected $_prefix = 'plugin';

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function activateAll() {
		$plugins = $this->mockable_get_plugins();

		foreach ($plugins as $plugin => $pluginData) {
			$skip = $this->_state->maybeSkip('plugin.' . $plugin);
			if ($skip == 'failed') {
				MOJOOutput::addSoftFailure('Activating plugin failed: ' . $pluginData['Name']);
				$this->_state->skip('plugin.' . $plugin, 'skip');
				continue;
			} elseif ($skip) {
				continue;
			}

			MOJOOutput::log("Activating plugin " . $plugin);

			$this->_state->skip('plugin.' . $plugin, 'failed');
			$result = $this->mockable_activate_plugin($plugin, null);
			$this->mockable_wp_cache_flush();

			if (is_wp_error($result)) {
				$message = $result->get_error_message();

				MOJOOutput::addSoftFailure("Activating plugin failed: " . $pluginData['Name'] . ': ' . $message);
				continue;
			}
			MOJOOutput::log("Activated plugin " . $plugin);

			$this->_state->skip('plugin.' . $plugin, 'skip');
		}
		MOJOOutput::log("Completed plugin activation");
	}
}
/**
 * [MOJOWordpressThemeHandler description]
 *
 * @author
 * @version
 * @package
 * @subpackage
 * @category
 * @link
 */
class MOJOWordpressThemeHandler extends MOJOBaseHandler {

	protected $_prefix = 'theme';

/**
 * [placeholder description]
 *
 * @return [type]
 */
	public function activate() {
		$theme = $this->_configuration['theme'];

		if (empty($theme)) {
			MOJOOutput::log("Skipping theme setup");
			return;
		}

		$skip = $this->_state->maybeSkip('theme.' . $theme);
		if ($skip == 'failed') {
			MOJOOutput::addSoftFailure('Failed to activate theme ' . $theme);
			$this->_state->skip('theme.' . $theme, 'skip');
			return;
		} elseif ($skip) {
			return;
		}

		$this->_state->skip('theme.' . $theme, 'failed');

		$themeClass = $this->wp_get_theme($theme);

		if (! ($themeClass->exists() && $themeClass->is_allowed()) ) {
			$message = $themeClass->exists() ? 'Not allowed to activate the theme: ' . $themeClass : 'Could not find theme ' . $theme;
			MOJOOutput::addSoftFailure($message);
			$this->_state->skip('theme.' . $theme, 'skip');

			return;
		}

		$this->mockable_switch_theme($themeClass->get_stylesheet());

		$this->_state->skip('theme.' . $theme, 'skip');
		MOJOOutput::log("Completed theme activation");
	}
}
// Disables automagictastic execution during unit testing.
if (count(get_included_files()) > 5)
	return;

$MOJOInstaller = new MOJOProcess();

$result = $MOJOInstaller->execute();
