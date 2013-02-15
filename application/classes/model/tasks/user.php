<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tasks_User extends ORM {
	//static $belongs_to = array('estado');
	protected $_belongs_to = array(
    	'task' => array('foreign_key' => 'task_id'),
    	'userInfo' => array('foreign_key' => 'userInfo_id'),
    );
}