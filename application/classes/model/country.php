<?php defined('SYSPATH') or die('No direct script access.');

class Model_Country extends ORM {
    
	public function rules()
	{
            return array(
                'nome' => array(
                    array('not_empty'),
                )
            );
	}

	public function labels()
	{
            return array(
                'nome'  => 'Nome',
            );
	}
}