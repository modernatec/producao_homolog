<?php defined('SYSPATH') or die('No direct script access.');

class Model_Custo extends ORM {

	protected $_belongs_to = array(
		'supplier' => array('foreign_key' => 'supplier_id'),
		'userInfo' => array('foreign_key' => 'userInfo_id'),
	);
	
}
