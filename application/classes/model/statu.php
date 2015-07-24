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

	/*
	public function filters()
	{
		return array(
			'status' => array(
				array(array($this, 'unique_name_exists'))
			),
		);
	}

	/**
	 * Tests if a unique key value exists in the database.
	 *
	 * @param   mixed    the value to test
	 * @param   string   field name
	 * @return  boolean
	 *
	public function unique_name_exists($value, $field = NULL)
	{
		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->execute($this->_db)
			->get('total_count');
	}
	*/
}
