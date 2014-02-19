<?php defined('SYSPATH') or die('No direct script access.');

class Model_Status_Type extends ORM {
	protected $_belongs_to = array(
    	'task' => array('model' => 'task', 'foreign_key' => 'task_id'),
    	'object' => array('model' => 'object', 'foreign_key' => 'object_id'),
    	'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'statu' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    );  
}