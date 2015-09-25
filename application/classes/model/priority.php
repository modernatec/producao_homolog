<?php defined('SYSPATH') or die('No direct script access.');

class Model_Priority extends ORM {
		
	protected $_has_one = array(
		'task' => array('model' => 'task', 'foreign_key' => 'priority_id')
	);
	
}
