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
	//static $belongs_to = array('estado');
	protected $_has_one = array(
		'priority' => array('model' => 'priority', 'foreign_key' => 'id',)
	);

	//protected $belongs_to = array(
	//	'priority' => array('model' => 'priority', 'foreign_key' => 'id',)
	//);


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
		    'description' => array(
	        	array('not_empty'),
		    ),
	    );
	}

	public function filters()
	{
		return array(
			'crono_date' => array(
				array(array($this, 'setup_date'))
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
		);
	}
}
