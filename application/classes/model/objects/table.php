<?php defined('SYSPATH') or die('No direct script access.');
	
class Model_Objects_Table extends ORM {
	protected $_belongs_to  = array(
    	'object' => array('model' => 'object', 'foreign_key' => 'object_id'),
	);	
	/*
	protected $_has_many = array(
		'anotacoes' => array('model' => 'anotacoes_object', 'foreign_key' => 'object_status_id'),
		'object' => array('through' => 'tables_objects'),
	);
	*/
	
}
