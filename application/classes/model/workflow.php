<?php defined('SYSPATH') or die('No direct script access.');

class Model_Workflow extends ORM {
	protected $_has_many = array(
		'workflow_status'  => array('model' => 'workflows_statu', 'through' => 'workflows_status',  'foreign_key' => 'workflow_id'),
	);

	public function labels()
	{
		return array(
			'name'  => 'Nome',
		);
	}

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array(array($this, 'unique_workflow'), array(':validation', ':field')),        
			)
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
	public function unique_workflow(Validation $validation, $field)
	{
		if ($this->unique_key_exists($validation[$field], 'name'))
		{
			$validation->error($field, 'unique_workflow', array($validation[$field]));
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