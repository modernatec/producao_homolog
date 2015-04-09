<?php defined('SYSPATH') or die('No direct script access.');

class Model_Status_Team extends ORM {
	protected $_belongs_to = array(
    	'team' => array('model' => 'team', 'foreign_key' => 'team_id'),
    	'status' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    );  
}