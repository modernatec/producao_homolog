<?php defined('SYSPATH') or die('No direct script access.');

class Model_ObjectsHistory extends ORM {
    
	protected $_belongs_to  = array(
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
	);	

	public function getStatus($id){
		return ORM::factory('task')->where('task_id', '=', $id)->or_where('id', '=', $id)->order_by('id', 'DESC')->find();
	}

	public function getReplies($id){
		return ORM::factory('task')->where('task_id', '=', $id)->find_all();
	}
	
}