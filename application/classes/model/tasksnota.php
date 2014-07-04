<?php defined('SYSPATH') or die('No direct script access.');

class Model_TasksNota extends ORM {
    
	protected $_belongs_to  = array(
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    	'to' => array('model' => 'userInfo', 'foreign_key' => 'task_to'),
	);	

	/****APAGAR***/
	public function getReplies($id){
		return ORM::factory('tasks_statu')->where('task_id', '=', $id)->where('status_id', '!=', '5')->find_all();
	}

	public function getHistory($id){
		return ORM::factory('taskView')->where('object_status_id', '=', $id)->order_by('id', 'DESC')->find_all();
	}
	
}