<?php defined('SYSPATH') or die('No direct script access.');

class Model_Supplier extends ORM {
        
        protected $_has_many = array(
		'objects'       => array('model' => 'object', 'through' => 'objects_suppliers'),
	);

	public function rules()
	{
            return array(
                'nome' => array(
                    array('not_empty'),
                ),
                'email' => array(
                    array('not_empty'),
                ),
                'telefone' => array(
                    array('not_empty'),
                ),
                'empresa' => array(
                    array('not_empty'),
                )
            );
	}

	public function labels()
	{
            return array(
                'name'  => 'Contato',
                'email' => 'Email',
                'telefone' => 'Telefone',
                'site' => 'Site',
                'empresa' => 'Empresa',
            );
	}
}
