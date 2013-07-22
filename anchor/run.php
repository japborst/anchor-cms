<?php

/*
 * Set your applications current timezone
 */
date_default_timezone_set(Config::app('timezone', 'UTC'));

/*
 * Define the application error reporting level based on your environment
 */
switch(constant('ENV')) {
	case 'dev':
		ini_set('display_error', true);
		error_reporting(-1);
		break;

	default:
		ini_set('display_error', false);
		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
		break;
}

/*
 * Set autoload directories to include your app models and libraries
 */
Autoloader::directory(array(
	APP . 'models',
	APP . 'libraries'
));

/**
 * Handle errors when detailed reporting is disabled
 */
Error::callback(function() {
	// try and clear any previous output
	ob_get_level() and ob_end_clean();

	Response::error(500, View::create('error/500')->render())->send();
});

/*
 * Set application locale
 */
i18n\Locale::setDefault(Config::app('language', 'en_GB'));

/**
 * Register composer autoloader
 */
file_exists($composer = APP . 'vendor/autoload' . EXT) and require $composer;

/**
 * Helpers
 */
require APP . 'helpers' . EXT;

/**
 * Anchor setup
 */
Anchor::setup();

/**
 * Import defined routes
 */
if(is_admin()) {
	require APP . 'routes/admin' . EXT;
	require APP . 'routes/categories' . EXT;
	require APP . 'routes/comments' . EXT;
	require APP . 'routes/fields' . EXT;
	require APP . 'routes/menu' . EXT;
	require APP . 'routes/metadata' . EXT;
	require APP . 'routes/pages' . EXT;
	require APP . 'routes/plugins' . EXT;
	require APP . 'routes/posts' . EXT;
	require APP . 'routes/users' . EXT;
	require APP . 'routes/variables' . EXT;
}
else {
	require APP . 'routes/site' . EXT;
}