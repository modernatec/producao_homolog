<?php defined('SYSPATH') or die('No direct script access.');

class Model_Formats_Supplier extends ORM {

	protected $_belongs_to = array(
		'format' => array('foreign_key' => 'format_id'),
		'supplier' => array('foreign_key' => 'supplier_id'),
	);
	
}
