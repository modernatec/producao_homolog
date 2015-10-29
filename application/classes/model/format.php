<?php defined('SYSPATH') or die('No direct script access.');

class Model_Format extends ORM {
    protected $_has_many = array(
        'objects' => array('model' => 'object', 'foreign_key' => 'format_id'),
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