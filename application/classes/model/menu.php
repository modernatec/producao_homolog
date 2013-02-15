<?php defined('SYSPATH') or die('No direct script access.');

class Model_Menu extends ORM {
		
	protected $_has_many = array(
		'roles' => array('through' => 'menus_roles')
	);
	
}
