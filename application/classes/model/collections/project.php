<?php defined('SYSPATH') or die('No direct script access.');

class Model_Collections_Project extends ORM {
	protected $_has_many = array(
		'collections' => array('model' => 'collections_project', 'through' => 'collections_projects'),
		'projects' => array('model' => 'collections_project', 'through' => 'collections_projects'),
	);
	
}