<?php defined('SYSPATH') or die('No direct script access.');

class Model_Statu extends ORM {
	protected $_has_many = array(
		'tasks' => array('through' => 'status_tasks'),
		'steps' => array('through' => 'status_tasks'),
		'taskflows' => array('model' => 'taskflow'),
		'tags' => array('model' => 'tag', 'through' => 'workflows_status_tags', 'foreign_key' => 'status_id'),	
	);

	protected $_has_one = array(
		'workflows_statu' => array('through' => 'workflows_status', 'foreign_key' => 'status_id'),
		'steps' => array('through' => 'status_tasks'),
	);

	protected $_belongs_to = array(
		'team'       => array('model' => 'team', 'foreign_key' => 'team_id'),
	);

	public function rules()
	{
		return array(
			'status' => array(
				array(array($this, 'unique_status'), array(':validation', ':field')),
			),
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
	public function unique_status(Validation $validation, $field)
	{
		if ($this->unique_key_exists($validation[$field], 'status'))
		{
			$validation->error($field, 'unique_status', array($validation[$field]));
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
		/*
		if ($field === NULL)
		{
			$field = 'status';
		}
		*/

		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->where($this->_primary_key, '!=', $this->pk())
			->execute($this->_db)
			->get('total_count');
	}
}
