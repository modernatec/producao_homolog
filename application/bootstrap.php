<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('America/Sao_Paulo');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('pt-br');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
/*if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}else{
		
}
 * 
 * */
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== FALSE){
    Kohana::$environment = Kohana::DEVELOPMENT;
    error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
}
if (strpos($_SERVER['HTTP_HOST'], '192.168.0.7') !== FALSE){
    Kohana::$environment = Kohana::TESTING;
    error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
}
if (strpos($_SERVER['HTTP_HOST'], '.com.br') !== FALSE){
    Kohana::$environment = Kohana::PRODUCTION;
    error_reporting(E_ALL ^ E_NOTICE ^ E_STRICT);
}
/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */

 
Kohana::init(array(
	'base_url'   => Kohana::$environment === Kohana::PRODUCTION ? 'http://www/' : 'http://localhost/',
    'caching'    => Kohana::$environment === Kohana::PRODUCTION,
    'profile'    => Kohana::$environment !== Kohana::PRODUCTION,
	'index_file' => FALSE,
	'erros'		 => TRUE,
));

//Kohana::$environment = Kohana::PRODUCTION;

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'cache'			=> MODPATH.'cache',      	// Caching with multiple backends
	'auth'       	=> MODPATH.'auth',       	// Basic authentication
	'sendmail'      => MODPATH.'sendmail',      // Basic Mail
	'database'   	=> MODPATH.'database',   	// Database access
	'image'      	=> MODPATH.'image',      	// Image manipulation
	'orm'			=> MODPATH.'orm',			// Object Relationship Mapping
	'pagination'    => MODPATH.'pagination',    // Object Paginator
	'amfphp'        => MODPATH.'amfphp',      	// AMFPHP integration
	'pagseguro'     => MODPATH.'pagseguro',     // Pague seguro
	'unittest'   	=> MODPATH.'unittest',   	// Unit testing
	// 'codebench'  => MODPATH.'codebench',  	// Benchmarking tool
	// 'userguide'  => MODPATH.'userguide',  	// User guide and API documentation
));


/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */


Route::set('login', 'login')
	->defaults(array(
		'controller' => 'user',
		'action'     => 'login',
		'directory'  => 'admin'		
	));

Route::set('logout', 'logout')
	->defaults(array(
		'controller' => 'user',
		'action'     => 'logout',
		'directory'  => 'admin'
	));
	
	
Route::set(
	'admin', 'admin(/<controller>(/<action>(/<page>)))', array('page' => '[0-9]+'))
	->defaults(array(
		'controller' => 'home',
		'action'     => 'index',
		'page'	 	 => 1,
		'directory'	 =>	'admin',
	));
	
	
/*Route::set(
	'site', 'site(/<controller>(/<action>(/<page>)))', array('page' => '[0-9]+'))
	->defaults(array(
		'controller' => 'home',
		'action'     => 'index',
		'page'	 	 => 1,
		'directory'	 =>	'site',
	));
	
 START CHANEL*
Route::set('canal', '<canal>(/<action>(/<page>))', array('page' => '[0-9]+', 'canal' => '(namoro|amigos)'))
	->defaults(array(
		'controller' => 'canal',
		'action'     => 'index',
		'page'	 	 => 1,
		'directory'	 => 'site',
	));
/*
Route::set('namoro', 'namoro(<controller>(/<action>(/<page>)))', array('page' => '[0-9]+'))
	->defaults(array(
		'controller' => 'canal',
		'action'     => 'index',
		'page'	 	 => 1,
		'directory'	 => 'site',
	));
*/
/* END CHANEL	
	
Route::set('amfphp/browser', 'amfphp/browser(/<controller>(/<action>))')
	->defaults(array(
		'controller' => 'amfphp',
		'action'     => 'browser',
	));
*//**
* Error router
*/
Route::set('error', 'error(/<action>)(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
	->defaults(array(
		'controller' => 'error',
		'action'     => 'index',
	));


Route::set('default', '(<controller>(/<action>(/<page>)))', array('page' => '[0-9]+'))
	->defaults(array(
		'controller' => 'home',
		'action'     => 'index',
		'page'	 	 => 1,
		'directory'	 => 'site',
	));
	
/*
// The URI to test
  $uri = '';
  // This will loop trough all the defined routes and
  // tries to match them with the URI defined above
  echo '<pre>';
  foreach (Route::all() as $r)
  {
      echo Debug::dump($r->matches($uri));
	  echo "<br />";
  }
  exit;
*/