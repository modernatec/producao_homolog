<?php defined('SYSPATH') or die('No direct script access.');

class Model_Statu extends ORM {
	protected $_has_many = array(
		'tasks' => array('through' => 'status_tasks'),
		'taskflows' => array('model' => 'taskflow'),
	);
}
