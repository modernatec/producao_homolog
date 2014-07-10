<?php defined('SYSPATH') or die('No direct script access.');

class Model_Supplier extends ORM {

    protected $_belongs_to = array(
        'team' => array('foreign_key' => 'team_id'),
    );

    protected $_has_one = array(
        'contato' => array('model' => 'contato', 'foreign_key'=>'tipo_id'),
    );

    public function getContato($supplier_id){
        $contato = ORM::factory('contato')->where('tipo_id', '=', $supplier_id)->find();
        return $contato;
    }

    public function getFormats($supplier_id){
        $formats = ORM::factory('formats_supplier')->where('supplier_id', '=', $supplier_id)->find_all();
        $formatos = "";
        foreach ($formats as $format) {
            $formatos.=$format->format->name." &bull; ";
        }

        return $formatos;
    }

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
