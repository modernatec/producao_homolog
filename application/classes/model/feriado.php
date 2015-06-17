<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feriado extends ORM {
        
    protected $_has_many = array(
		'objects' => array('model' => 'object', 'through' => 'objects_materias'),
	);


	public function rules()
	{
		return array(
			'feriado' => array(
				array('not_empty'),
			)
		);
	}

	public function labels()
	{
		return array(
			'feriado'  => 'Feriado',
		);
	}

	public function filters()
	{
		return array(
			'data' => array(
				array(array($this, 'setup_date'))
			),
		);
	}

	public function setup_date($value)
	{
		return  date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $value)));
	}
}