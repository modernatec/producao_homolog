<?php defined('SYSPATH') or die('No direct script access.');

class Model_Media extends ORM {

	public function rules()
	{
            return array(
                'tag' => array(
                    array('not_empty'),
                    
                )
            );
	}

	public function labels()
	{
            return array(
                'tag'  => 'Tag',
            );
	}
}
