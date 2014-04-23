<?php defined('SYSPATH') or die('No direct script access.');

class Model_TaskUser extends ORM {
	//protected $load_with = array('statu');

	protected $_belongs_to  = array(
		'object' => array('foreign_key' => 'object_id'),
		'priority' => array('model' => 'priority', 'foreign_key' => 'priority_id'),
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    	'task' => array('model' => 'task', 'foreign_key' => 'task_id'),
    	'to' => array('model' => 'userInfo', 'foreign_key' => 'task_to'),
	);	

	public function getStatus($id){
		return ORM::factory('task')->where('task_id', '=', $id)->or_where('id', '=', $id)->order_by('id', 'DESC')->find();
	}

	public function getReplies($id){
		return ORM::factory('task')->where('task_id', '=', $id)->find_all();
	}

	public function getTasks($id){
		return ORM::factory('taskUser')->where('task_to', '=', $id)->count_all();
	}


	public function rules()
	{
	    return array(
            'userInfo_id' => array(
                array('not_empty'),
            ),
            
			'status_id' => array(
				array('not_empty'),
			),
			'topic' => array(
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
