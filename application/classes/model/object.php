<?php defined('SYSPATH') or die('No direct script access.');

class Model_Object extends ORM {
    
	protected $_has_many = array(
		'sfwprods'       => array('model' => 'sfwprod', 'through' => 'objects_sfwprods'),
		'suppliers'      => array('model' => 'supplier', 'through' => 'objects_suppliers'),
		'materias'      => array('model' => 'materia', 'through' => 'objects_materias'),
	);
        
	protected $_belongs_to  = array(
		'typeobject' => array('foreign_key' => 'typeobject_id'),
		'segmento' => array('foreign_key' => 'segmento_id'),
		'country' => array('foreign_key' => 'country_id'),
	);

	public function rules()
	{
		return array(
			'nome_obj' => array(
				array('not_empty'),
			),
			'nome_arq' => array(
				array('not_empty'),
			),
			'typeobject_id' => array(
				array('not_empty'),
			),
			'colecao' => array(
				array('not_empty'),
				),
			'segmento_id' => array(
				array('not_empty'),
			),
			'arq_aberto' => array(
				array('not_empty'),
			),
			'extensao_arq' => array(
				array('not_empty'),
				),
			'interatividade' => array(
				array('not_empty'),
			),
			'empresa' => array(
				array('not_empty'),
			),
			'country_id' => array(
				array('not_empty'),
			)
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
			'nome_obj'  => 'Nome do Objeto',
			'nome_arq' => 'Nome do arquivo',
			'typeobject_id' => 'Tipo do objeto',
			'colecao' => 'Coleção',
			'segmento_id'  => 'Segmento',
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