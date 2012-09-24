<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Project extends ORM {

	public function rules()
	{
        return array(
            'name' => array(
                array('not_empty'),
                array(array($this, 'name_available'), array(':validation', ':field')),
            ),
            'target' => array(
                array('not_empty'),
            ),
            'description' => array(
                array('not_empty'),
            ),
            'folder' => array(
            	array('not_empty'),
	        )
        );
	}

	public function labels()
	{
            return array(
                'name'  => 'Projeto',
                'target' => 'Seguimento',
                'description' => 'Descrição',
                'folder' => 'Pasta',
            );
	}

	public function name_available(Validation $validation, $field)
	{	
		if ($this->unique_name_exists($validation[$field], 'name'))
		{
			$validation->error($field, 'name_available', array($validation[$field]));
		}
	}
        
	public function unique_name_exists($value, $field = NULL)
	{
		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->execute($this->_db)
			->get('total_count');
	}
}
