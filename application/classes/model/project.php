<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends ORM {

	protected $_belongs_to = array(
		'segmento' => array('model' => 'segmento', 'foreign_key' => 'segmento_id'),		
	);

	protected $_has_many = array(
		'collections' => array('model' => 'collection', 'foreign_key' => 'project_id'),		
	);

	public function rules()
	{
        return array(
            'name' => array(
                array('not_empty'),  
                array(array($this, 'unique_project'), array(':validation', ':field')),                    
            ),
            'segmento_id' => array(
                array('not_empty'),
            ),
            
        );
	}
	//array(array($this, 'name_available'), array(':validation', ':field')),

	public function labels()
	{
        return array(
            'name'  => 'Projeto',
            'segmento_id' => 'Segmento',
            'description' => 'Descrição',
            'pasta' => 'Pasta',
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
	public function unique_project(Validation $validation, $field)
	{
		if ($this->unique_key_exists($validation[$field], 'name'))
		{
			$validation->error($field, 'unique_project', array($validation[$field]));
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
