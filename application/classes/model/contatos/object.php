<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contatos_Object extends ORM {
	protected $_belongs_to = array(
    	'contato' => array('model' => 'contato', 'through' => 'contatos_objects',  'foreign_key' => 'contato_id'),
    	'object' => array('model' => 'object', 'through' => 'contatos_objects', 'foreign_key' => 'object_id'),
    );  
}