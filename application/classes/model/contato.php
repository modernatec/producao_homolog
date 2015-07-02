<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contato extends ORM {
	protected $_belongs_to = array(
		'service' => array('foreign_key' => 'service_id'),
	);
}
