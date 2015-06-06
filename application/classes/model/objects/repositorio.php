<?php defined('SYSPATH') or die('No direct script access.');

class Model_Objects_Repositorio extends ORM {
	
	protected $_belongs_to  = array(
    	'object' => array('model' => 'object', 'foreign_key' => 'object_id'),
    	'repositorio' => array('model' => 'repositorio', 'foreign_key' => 'repositorio_id'),
	);	


}
