<?php defined('SYSPATH') or die('No direct script access.');

class Model_Custo extends ORM {

	protected $_belongs_to = array(
		'project' => array('foreign_key' => 'project_id'),
		'materia' => array('foreign_key' => 'materia_id'),
	);

	protected $_has_many = array(
		'objects' => array('model' => 'object', 'foreign_key' => 'collection_id'),
	);
	
}
