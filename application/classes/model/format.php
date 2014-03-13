<?php defined('SYSPATH') or die('No direct script access.');

class Model_Format extends ORM {

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