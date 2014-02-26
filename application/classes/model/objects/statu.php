<?php defined('SYSPATH') or die('No direct script access.');

class Model_Objects_statu extends ORM {
	
	protected $_belongs_to  = array(
		'userInfo' => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
	);	

	public function filters()
	{
		return array(
			'crono_date' => array(
				array(array($this, 'setup_date'))
			),
		);
	}

	public function setup_date($value)
	{
		return  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $value)));
	}
}
