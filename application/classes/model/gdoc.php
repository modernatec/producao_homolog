<?php defined('SYSPATH') or die('No direct script access.');

class Model_Gdoc extends ORM {
	protected $_belongs_to  = array(
		'object' => array('foreign_key' => 'object_id'),
	);
}
