<?php defined('SYSPATH') or die('No direct script access.');

class Model_Objects_path extends ORM {
	
	protected $_belongs_to  = array(
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    	'task' => array('model' => 'task', 'foreign_key' => 'task_id'),
    	'object' => array('model' => 'object', 'foreign_key' => 'object_id'),
	);	

	protected $_has_many = array(
		'tasks' => array('model' => 'task', 'foreign_key' => 'object_status_id'),
		'anotacoes' => array('model' => 'anotacoes_object', 'foreign_key' => 'object_status_id'),
	);

}
