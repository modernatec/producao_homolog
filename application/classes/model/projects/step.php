<?php defined('SYSPATH') or die('No direct script access.');

class Model_Projects_Step extends ORM {
	protected $_belongs_to = array(
    	'project' => array('model' => 'project', 'foreign_key' => 'project_id'),
    );  

    protected $_has_one = array(
	    'task' => array('model'   => 'task', 'through' => 'status_tasks'),
	);

	protected $_has_many = array(
		'status_tasks' => array('model' => 'status_task', 'through' => 'status_tasks'),
	);
	
}