<?php defined('SYSPATH') or die('No direct script access.');

class Model_ObjectStatus extends ORM {
    
	protected $_has_many = array(
		'sfwprods'       => array('model' => 'sfwprod', 'through' => 'objects_sfwprods'),		
		'tasks' => array('model' => 'task', 'foreign_key' => 'object_id'),
		'statu' => array('model' => 'status_type', 'foreign_key' => 'status_id'),
	);
        
	protected $_belongs_to  = array(
		'typeobject' => array('foreign_key' => 'typeobject_id'),
		'country' => array('foreign_key' => 'country_id'),
		'collection' => array('foreign_key' => 'collection_id'),		
		'supplier' => array('model' => 'supplier', 'through' => 'objects_suppliers'),
	);


	
}