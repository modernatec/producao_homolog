<?php defined('SYSPATH') or die('No direct script access.');

class Model_Supplier extends ORM {
        
    protected $_has_many = array(
		'objects'       => array('model' => 'object', 'through' => 'objects_suppliers'),
        
	);

    protected $_has_one = array(
        'contato' => array('model' => 'contato', 'through' => 'contatos', 'foreign_key'=>'tipo_id'),
    );

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
