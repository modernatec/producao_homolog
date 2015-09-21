<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tasks_Statu extends ORM {
	protected $_belongs_to = array(
    	'task' => array('foreign_key' => 'task_id'),
    	'userInfo' => array('foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    	'user' => array('model' => 'userInfo', 'foreign_key' => 'to'),
    );
}