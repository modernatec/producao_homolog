<?php defined('SYSPATH') or die('No direct script access.');

class Model_Software extends ORM {
        
        protected $_has_many = array(
		'objects'       => array('model' => 'object', 'through' => 'objects_sfwprods'),
	);

	public function rules()
	{
            return array(
                'nome' => array(
                    array('not_empty'),
                )
            );
	}

	public function labels()
	{
            return array(
                'nome'  => 'Nome',
            );
	}
}