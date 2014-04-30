<?php defined('SYSPATH') or die('No direct script access.');

class Model_Anotacoes_Object extends ORM {
	
	protected $_belongs_to  = array(
		'object' => array('foreign_key' => 'object_id'),
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
	);	
	
}
