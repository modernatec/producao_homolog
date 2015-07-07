<?php defined('SYSPATH') or die('No direct script access.');

class Model_Workflow extends ORM {
	protected $_has_many = array(
		'workflow_status'  => array('model' => 'workflows_statu', 'through' => 'workflows_status',  'foreign_key' => 'workflow_id'),
	);

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
			)
		);
	}

	public function labels()
	{
		return array(
			'name'  => 'Nome',
		);
	}
}