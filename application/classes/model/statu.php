<?php defined('SYSPATH') or die('No direct script access.');

class Model_Statu extends ORM {
	protected $_has_many = array(
		'tasks' => array('through' => 'status_tasks'),
		'steps' => array('through' => 'status_tasks'),
		'taskflows' => array('model' => 'taskflow'),
	);

	protected $_belongs_to = array(
		'team'       => array('model' => 'team', 'foreign_key' => 'team_id'),
	);
}
