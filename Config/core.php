<?php

if (file_exists(APP . 'Config' . DS . 'croogo.php')) {
	require APP . 'Config' . DS . 'croogo.php';
} else {
	if (!defined('LOG_ERROR')) {
		define('LOG_ERROR', LOG_ERR);
	}

	Configure::write('Error', array(
		'handler' => 'ErrorHandler::handleError',
		'level' => E_ALL & ~E_DEPRECATED,
		'trace' => true
	));

	Configure::write('Exception', array(
		'handler' => 'ErrorHandler::handleException',
		'renderer' => 'ExceptionRenderer',
		'log' => true
	));

	Configure::write('Session', array(
		'defaults' => 'php',
		'ini' => array(
			'session.cookie_httponly' => 1
		)
	));
}

define('UNIX_DAY', 24*60*60);
define('UNIX_WEEK', UNIX_DAY * 7);
define('CONNECT_ACTIVE', 192);
define('NUMBER_OF_COUNTERS', 10);