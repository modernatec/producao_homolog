<?php defined('SYSPATH') or die('No direct script access.');

class Model_Status_Task extends ORM {
	protected $_belongs_to = array(
    	'task' => array(),
    	'userInfo' => array(),
    	'statu' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    );  
	
	public function getFiles($id){
		return ORM::factory('file')->where('model', '=', 'task')->and_where('model_id', '=', $id)->find_all();	
	}  
}