<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ongoing extends ORM {
    
	protected $_belongs_to  = array(
		'object' => array('foreign_key' => 'object_id'),
		'priority' => array('model' => 'priority', 'foreign_key' => 'priority_id'),
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    	//'task' => array('model' => 'task', 'foreign_key' => 'task_id'),
    	'to' => array('model' => 'userInfo', 'foreign_key' => 'task_to'),
    	'tag' => array('model' => 'tag', 'foreign_key' => 'tag_id'),
	);	

	public function getStatus($id){
		return ORM::factory('task')->where('task_id', '=', $id)->or_where('id', '=', $id)->order_by('id', 'DESC')->find();
	}

	public function getReplies($id){
		return ORM::factory('task')->where('task_id', '=', $id)->find_all();
	}
	
}