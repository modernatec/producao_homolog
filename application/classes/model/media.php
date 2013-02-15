<?php defined('SYSPATH') or die('No direct script access.');

class Model_Media extends ORM {
	
	public function getFiles($id){
		return ORM::factory('file')->where('model', '=', 'media')->and_where('model_id', '=', $id)->find_all();	
	} 
		
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
