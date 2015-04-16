<?php defined('SYSPATH') or die('No direct script access.');

class Model_Task extends ORM {
	//protected $load_with = array('statu');

	protected $_belongs_to  = array(
		'object' => array('foreign_key' => 'object_id'),
		'priority' => array('model' => 'priority', 'foreign_key' => 'priority_id'),
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    	'to' => array('model' => 'userInfo', 'foreign_key' => 'task_to'),
    	'tag' => array('model' => 'tag', 'foreign_key' => 'tag_id'),
	);	

	protected $_has_one = array(
		'reply' => array('model' => 'tasks_statu', 'foreign_key' => 'task_id'),
	);

	/*
	public function getStatus($id){
		return ORM::factory('tasks_statu')->where('task_id', '=', $id)->order_by('id', 'DESC')->find();
	}

	
	public function getReplies($id){
		return ORM::factory('tasks_statu')->where('task_id', '=', $id)->find_all();
	}
	*/

	public function getTasks($id){
		return ORM::factory('task')->where('task_to', '=', $id)->count_all();
	}

	public function getUserTasks($id){
		return ORM::factory('task')->where('task_to', '=', $id)->where('ended', '=', '0')->count_all();
	}

	

	public function rules()
	{
	    return array(
            'userInfo_id' => array(
                array('not_empty'),
            ),
			
	    );
	}

	/*
	'description' => array(
				array(array($this, 'description_available'), array(':validation', ':field')),
			),
	*/

	public function filters()
	{
		return array(
			'crono_date' => array(
				array(array($this, 'setup_date'))
			),
			'taxonomia' => array(
				array('Utils_Helper::limparStr')
			)
		);
	}

	/**
	 * Does the reverse of unique_key_exists() by triggering error if folder exists.
	 * Validation callback.
	 *
	 * @param   Validation  Validation object
	 * @param   string      Field folder
	 * @return  void
	 */
	public function description_available(Validation $validation, $field)
	{	
		//&& $this->unique_name_exists($validation[$field], 'status_id') && $this->unique_name_exists($validation[$field], 'created_at') && $this->unique_name_exists($validation[$field], 'topic')
		if ($this->unique_name_exists($validation[$field], 'description') && $this->unique_name_exists($validation['status_id'], 'status_id') && $this->unique_name_exists($validation['topic'], 'topic'))
		{
			$validation->error($field, 'name_available', array($validation[$field]));
		}
	}

	/**
	 * Tests if a unique key value exists in the database.
	 *
	 * @param   mixed    the value to test
	 * @param   string   field name
	 * @return  boolean
	 */
	public function unique_name_exists($value, $field = NULL)
	{
		return (bool) DB::select(array('COUNT("*")', 'total_count'))
			->from($this->_table_name)
			->where($field, '=', $value)
			->execute($this->_db)
			->get('total_count');
	}


	public function setup_date($value)
	{
		return  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $value)));
	}

	public function labels()
	{
		return array(
			'title'         => __('Título'),
			'priority_id'   => __('Prioridade'),
			'project_id'    => __('Projeto'),
			'userInfo_id'	=> __('Usuário responsável'),
			'crono_date'	=> __('Data de entrega'),
			'description'	=> __('Descrição'),
			'taxonomia'	=> __('Taxonomia'),
		);
	}
}
