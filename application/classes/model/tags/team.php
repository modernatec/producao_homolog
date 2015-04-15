<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tags_Team extends ORM {
	protected $_belongs_to = array(
    	'team' => array('model' => 'team', 'foreign_key' => 'team_id'),
    	'tag' => array('model' => 'tag', 'foreign_key' => 'tag_id'),
    );  
}