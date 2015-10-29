<?php defined('SYSPATH') or die('No direct script access.');

class Model_Collection extends ORM {
	protected $_belongs_to = array(
		'project' => array('foreign_key' => 'project_id'),
		'materia' => array('foreign_key' => 'materia_id'),
		'segmento' => array('foreign_key' => 'segmento_id'),
	);

	protected $_has_many = array(
		'objects' => array('model' => 'object', 'foreign_key' => 'collection_id'),
		'userInfos' => array('model' => 'userInfo', 'through' => 'collections_userInfos',  'foreign_key' => 'collection_id'),
	);
	
	
	public function rules()
	{
            return array(
                'name' => array(
                    array('not_empty'),
                    array(array($this, 'unique_collection'), array(':validation', ':field')),
                ),
                'op' => array(
                    array('not_empty'),                    
                ),
                'materia_id' => array(
                    array('not_empty'),
                ),
                'ano' => array(
                    array('not_empty'),
                )
            );
	}

	public function labels()
	{
            return array(
                'name'  => 'Coleção',
                'project_id' => 'Projeto',
            );
	}

	public function filters()
	{
		return array(
			'fechamento' => array(
				array(array($this, 'setup_date'))
			),
			
		);
	}

	public function setup_date($value)
	{
		return  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $value)));
	}

	/**
	 * Does the reverse of unique_key_exists() by triggering error if email exists.
	 * Validation callback.
	 *
	 * @param   Validation  Validation object
	 * @param   string      Field name
	 * @return  void
	 */
	public function unique_collection(Validation $validation, $field)
	{
		if ($this->unique_collection_exists($validation[$field], 'name'))
		{
			
			$validation->error($field, 'unique_collection', array($validation[$field]));
		}
	}

	/**
	 * Tests if a unique key value exists in the database.
	 *
	 * @param   mixed    the value to test
	 * @param   string   field name
	 * @return  boolean
	 */
	public function unique_collection_exists($value, $field = NULL)
	{	
		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->where($this->_primary_key, '!=', $this->pk())
			->execute($this->_db)
			->get('total_count');
	}
}
