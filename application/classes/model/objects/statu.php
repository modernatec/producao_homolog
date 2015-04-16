<?php defined('SYSPATH') or die('No direct script access.');

class Model_Objects_statu extends ORM {
	
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

	/****APAGAR***
	public function getStatus($id){
		return ORM::factory('tasks_statu')->where('task_id', '=', $id)->order_by('id', 'DESC')->find();
	}

	public function getReplies($id){
		return ORM::factory('tasks_statu')->where('task_id', '=', $id)->find_all();
	}

	public function getHistory($id){
		return ORM::factory('tasksnota')->where('object_status_id', '=', $id)->order_by('created_at', 'DESC')->find_all();
	}
	*/

	public function filters()
	{
		return array(
			'crono_date' => array(
				array(array($this, 'setup_date'))
			),
		);
	}

	public function setup_date($value)
	{
		return  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $value)));
	}
}
