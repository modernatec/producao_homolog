<?php defined('SYSPATH') or die('No direct script access.');

class Model_Object extends ORM {
    
	protected $_has_many = array(
		'sfwprods'       => array('model' => 'sfwprod', 'through' => 'objects_sfwprods'),		
		'tasks' => array('model' => 'task', 'foreign_key' => 'object_id'),
	);
        
	protected $_belongs_to  = array(
		'typeobject' => array('foreign_key' => 'typeobject_id'),
		'country' => array('foreign_key' => 'country_id'),
		'collection' => array('foreign_key' => 'collection_id'),
		'statu' => array('foreign_key' => 'status_id'),
		'supplier' => array('model' => 'supplier', 'through' => 'objects_suppliers'),
	);


	public function getStatus($objId){
		$status = ORM::factory('objects_statu')->where('object_id', '=', $objId)->order_by("id", 'DESC')->find();
		return (is_null($status->statu->status)) ? "não iniciado" : $status->statu->status;
	}


	public function rules()
	{
		return array(
			'title' => array(
				array('not_empty'),
			),
			'taxonomia' => array(
				array('not_empty'),
			),
			'collection_id' => array(
				array('not_empty'),
			),
		);
	}
        
    public function filters()
	{
		return array(
			'data_lancamento' => array(
				array(array($this, 'setup_date'))
			)
		);
	}

	public function setup_date($value)
	{
		return  date('Y-m-d', strtotime(str_replace('/', '-', $value)));
    }

	public function labels()
	{
		return array(
			'title'  => 'Nome do Objeto',
			'taxonomia' => 'Nome do arquivo',
			'typeobject_id' => 'Tipo do objeto',
			'collection_id' => 'Coleção',
			'arq_aberto' => 'Arquivo aberto',
			'extensao_arq' => 'Extensão do arquivo',
			'interatividade'  => 'Interatividade',
			'empresa' => 'Empresa',
			'data_lancamento' => 'Data do lançamento',
			'sinopse' => 'Sinopse',
			'obs' => 'Observações',
			'country_id' => 'País',
		);
	}
}