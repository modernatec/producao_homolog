<?php defined('SYSPATH') or die('No direct script access.');

class Model_Object extends ORM {
    
	protected $_has_many = array(
		'sfwprods'       => array('model' => 'sfwprod', 'through' => 'objects_sfwprods'),		
		'tasks' => array('model' => 'task', 'foreign_key' => 'object_id'),
		'status' => array('model' => 'statu', 'through' => 'objects_status', 'foreign_key' => 'object_id'),
		'object_reap' => array('model' => 'object', 'through' => 'objects_paths', 'foreign_key' => 'object_id'),
		'repositorios' => array('model' => 'repositorio', 'through' => 'objects_repositorios', 'foreign_key' => 'object_id'),
		'contatos' => array('model' => 'contato', 'through' => 'contatos_objects', 'foreign_key' => 'object_id'),
		'suppliers_objects' => array('model' => 'suppliers_object', 'foreign_key' => 'object_id'),
		'suppliers' => array('model' => 'supplier', 'through' => 'suppliers_object', 'foreign_key' => 'object_id'),
	);

	protected $_has_one = array(
		'gdoc' => array('model' => 'gdoc', 'foreign_key' => 'object_id'),		
	);
        
	protected $_belongs_to  = array(
		'typeobject' => array('foreign_key' => 'typeobject_id'),
		'country' => array('foreign_key' => 'country_id'),
		'collection' => array('foreign_key' => 'collection_id'),
		'project' => array('foreign_key' => 'project_id'),		
		'supplier' =>  array('foreign_key' => 'supplier_id'),
		'audiosupplier' => array('model' => 'supplier', 'foreign_key' => 'audiosupplier_id'),
		'objectStatus' => array('model' => 'objectStatu', 'through' => 'objectstatus', 'foreign_key' => 'id'),
		'format' => array('model' => 'format', 'foreign_key' => 'format_id'),
		'workflow' => array('model' => 'workflow', 'foreign_key' => 'workflow_id'),
	);


	public function rules()
	{
		return array(
			'title' => array(
				array('not_empty'),
			),
			'taxonomia' => array(
				array('not_empty'),
				array(array($this, 'unique_taxonomia'), array(':validation', ':field')),
			),
			'collection_id' => array(
				array('not_empty'),
			),
		);
	}
        
    public function filters()
	{
		return array(
			'crono_date' => array(
				array(array($this, 'setup_date'))
			),
			'planned_date' => array(
				array(array($this, 'setup_date'))
			),
			'delivered_date' => array(
				array(array($this, 'setup_date'))
			),

			'title' => array(
				array(array($this, 'limpaString'))
			),

			'taxonomia' => array(
				array(array($this, 'limpaString'))
			)
		);
	}

	public function setup_date($value)
	{
		return  date('Y-m-d', strtotime(str_replace('/', '-', $value)));
    }

    public function limpaString($value){
    	return trim($value);
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

	/**
	 * Does the reverse of unique_key_exists() by triggering error if email exists.
	 * Validation callback.
	 *
	 * @param   Validation  Validation object
	 * @param   string      Field name
	 * @return  void
	 */
	public function unique_taxonomia(Validation $validation, $field)
	{
		if ($this->unique_key_exists($validation[$field], 'taxonomia'))
		{
			$validation->error($field, 'unique_taxonomia', array($validation[$field]));
		}
	}

	/**
	 * Tests if a unique key value exists in the database.
	 *
	 * @param   mixed    the value to test
	 * @param   string   field name
	 * @return  boolean
	 */
	public function unique_key_exists($value, $field = NULL)
	{	
		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->where($this->_primary_key, '!=', $this->pk())
			->execute($this->_db)
			->get('total_count');
	}
}