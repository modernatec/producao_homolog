<?php defined('SYSPATH') or die('No direct script access.');

class Model_Supplier extends ORM {

    protected $_belongs_to = array(
        'team' => array('foreign_key' => 'team_id'),
    );

    protected $_has_one = array(
        'contato' => array('model' => 'contato', 'foreign_key'=>'tipo_id'),
    );

    protected $_has_many = array(
        'formats' => array('model' => 'format', 'through' => 'formats_suppliers', 'foreign_key' => 'supplier_id'),
        'contatos' => array('model' => 'contato', 'through' => 'contatos_suppliers', 'foreign_key' => 'supplier_id'),
    );

	public function rules()
	{
            return array(
                'name' => array(
                    //array('not_empty'),
                ),
                'email' => array(
                    //array('not_empty'),
                ),
                'telefone' => array(
                    //array('not_empty'),
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
