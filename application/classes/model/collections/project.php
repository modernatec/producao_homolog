<?php defined('SYSPATH') or die('No direct script access.');

class Model_Collections_Project extends ORM {
	protected $_has_many = array(
		'collections' => array('model' => 'collections_project', 'through' => 'collections_projects'),
		'projects' => array('model' => 'collections_project', 'through' => 'collections_projects'),
	);
	
	protected $_belongs_to = array(
		'collection' => array('foreign_key' => 'collection_id'),
		'project' => array('foreign_key' => 'project_id'),
	);
}