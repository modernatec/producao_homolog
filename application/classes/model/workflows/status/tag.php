<?php defined('SYSPATH') or die('No direct script access.');

class Model_Workflows_Status_Tag extends ORM {
	protected $_belongs_to = array(
		'tag' => array('foreign_key' => 'tag_id'),
	);
}