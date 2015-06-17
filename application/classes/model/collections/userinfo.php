<?php defined('SYSPATH') or die('No direct script access.');

class Model_Collections_Userinfo extends ORM {
	protected $_has_many = array(
		'userInfos'       => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
	);
	
	protected $_belongs_to = array(
		'collection' => array('foreign_key' => 'collection_id'),
	);
}