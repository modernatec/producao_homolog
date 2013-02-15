<?php defined('SYSPATH') or die('No direct script access.');

class Model_Curriculum extends ORM {
        
    protected $_has_many = array(
		'files' => array('through' => 'files')
	);
	
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),                    
			),
			'objective' => array(
				array('not_empty'),                    
			)
		);
	}

	public function labels()
	{
		return array(
			'name'  => 'Nome',
			'objective'  => 'Objetivo',
			'description'  => 'Descrição',
		);
	}
}
