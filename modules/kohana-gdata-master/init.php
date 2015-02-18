<?php defined('SYSPATH') or die('No direct script access.');
	/*
	// Load Zend's Autoloader
	if ($path = Kohana::find_file('vendors', 'Zend/Loader'))
	{
		ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(dirname($path)));
		require_once 'Zend/Loader/Autoloader.php';
		Zend_Loader_Autoloader::getInstance();
	}
	*/
	

	/**
	 * Autoload Zend gdata library
	 */
	
	if ($path = Kohana::find_file('vendors', 'Zend/Loader'))
	{
	    ini_set('include_path', ini_get('include_path').PATH_SEPARATOR.dirname(dirname($path)));
	    require_once 'Zend/Loader.php';
	    Zend_Loader::loadClass('Zend_Gdata_AuthSub');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');

		//Zend_Loader::loadClass('Zend_Gdata_Spreadsheets_WorksheetFeed');
		//Zend_Loader::loadClass('Zend_Gdata_Spreadsheets_WorksheetEntry');

		
		Zend_Loader::loadClass('Zend_Gdata_Docs');
	    /*
	    Zend_Loader::loadClass('Zend_Gdata');
		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Calendar');
		Zend_Loader::loadClass('Zend_Http_Client');
		Zend_Loader::loadClass('Zend_Gdata_AuthSub');
		*/
	}
	
	