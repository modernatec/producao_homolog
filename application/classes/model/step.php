<?php defined('SYSPATH') or die('No direct script access.');

class Model_Step extends ORM {
	protected $_has_one = array(
	    'task' => array('model'   => 'task', 'through' => 'status_tasks'),
	);

	protected $_has_many = array(
		'status_tasks' => array('model' => 'status_task', 'through' => 'status_tasks'),
	);
	
}