<?php defined('SYSPATH') or die('No direct script access.');

class Model_Repositorio extends ORM {
        
    protected $_has_many = array(
		'objects' => array('model' => 'object', 'through' => 'objects_materias'),
	);

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
			)
		);
	}

	public function labels()
	{
		return array(
			'name'  => 'Nome',
		);
	}
}