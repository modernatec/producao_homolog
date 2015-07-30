<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Tag extends ORM {
	//static $belongs_to = array('estado');
	protected $_belongs_to = array(
		'task'       => array('model' => 'task', 'foreign_key' => 'task_id'),
	);
    
    

	public function labels()
	{
            return array(
                'tag'  => 'Tag',
				'type'  => 'Model da tag',
            );
	}

	public function rules()
	{
        return array(
            'tag' => array(
                array('not_empty'), 
                array(array($this, 'unique_tag'), array(':validation', ':field')),                   
            ),
			'type' => array(
                array('not_empty'),                    
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
	public function unique_tag(Validation $validation, $field)
	{
		if ($this->unique_key_exists($validation[$field], 'tag'))
		{
			$validation->error($field, 'unique_tag', array($validation[$field]));
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
