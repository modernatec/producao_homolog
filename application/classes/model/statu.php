<?php defined('SYSPATH') or die('No direct script access.');

class Model_Statu extends ORM {
	protected $_has_many = array(
		'tasks' => array('through' => 'status_tasks'),
		'steps' => array('through' => 'status_tasks'),
		'taskflows' => array('model' => 'taskflow'),
		'tags' => array('model' => 'tag', 'through' => 'workflows_status_tags', 'foreign_key' => 'status_id'),	
	);

	protected $_has_one = array(
		'workflows_statu' => array('through' => 'workflows_status', 'foreign_key' => 'status_id'),
		'steps' => array('through' => 'status_tasks'),
	);

	protected $_belongs_to = array(
		'team'       => array('model' => 'team', 'foreign_key' => 'team_id'),
	);
}
