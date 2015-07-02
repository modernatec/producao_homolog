<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contatos_Supplier extends ORM {
	protected $_belongs_to = array(
    	'contato' => array('model' => 'contato', 'through' => 'contatos_suppliers',  'foreign_key' => 'contato_id'),
    	'supplier' => array('model' => 'supplier', 'through' => 'contatos_suppliers', 'foreign_key' => 'supplier_id'),
    );  
}