<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Task extends ORM {
	protected $load_with = array('statu');

	//static $belongs_to = array('estado');
	protected $_belongs_to  = array(
		'project' => array('foreign_key' => 'project_id'),
		'priority' => array('model' => 'priority', 'foreign_key' => 'priority_id'),
		'user' => array('model' => 'user', 'foreign_key' => 'user_id'),
	);	

	protected $_has_many = array(
	    'status' => array('model'   => 'statu', 'through' => 'status_tasks'),
	    'users' => array('model'   => 'user', 'foreign_key' =>'task_id', 'through' => 'tasks_users'),
	  	  
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
                'user_id' => array(
                    array('not_empty'),
                ),
                'pasta' => array(
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
                        'pasta' => array(
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
			'user_id'		=> __('Usuário responsável'),
			'crono_date'	=> __('Data de entrega'),
			'description'	=> __('Descrição'),
			'pasta'	=> __('Pasta'),
		);
	}
}
