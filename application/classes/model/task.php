<?php defined('SYSPATH') or die('No direct script access.');

class Model_Task extends ORM {
	//protected $load_with = array('statu');

	protected $_belongs_to  = array(
		'project' => array('foreign_key' => 'project_id'),
		'priority' => array('model' => 'priority', 'foreign_key' => 'priority_id'),
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
	);	

	protected $_has_many = array(
	    'status' => array('model'   => 'statu', 'through' => 'status_tasks'),
	    'userInfos' => array('model'   => 'userInfo', 'foreign_key' =>'task_id', 'through' => 'tasks_users'),
	);


	public function rules()
	{
	    return array(
	        'title' => array(
		        array('not_empty'),
	        ),
	        'crono_date' => array(
	        	array('not_empty'),
		    ),
	        'priority_id' => array(
	        	array('not_empty'),
		    ),
                'project_id' => array(
                    array('not_empty'),
                ),
                'userInfo_id' => array(
                    array('not_empty'),
                ),
                'taxonomia' => array(
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
