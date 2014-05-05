<?php defined('SYSPATH') or die('No direct script access.');

class Model_ObjectStatu extends ORM {
    
	protected $_has_many = array(
		'sfwprods'       => array('model' => 'sfwprod', 'through' => 'objects_sfwprods'),		
		'tasks' => array('model' => 'task', 'foreign_key' => 'object_id'),
		
	);
        
	protected $_belongs_to  = array(
		'typeobject' => array('foreign_key' => 'typeobject_id'),
		'country' => array('foreign_key' => 'country_id'),
		'collection' => array('foreign_key' => 'collection_id'),		
		'supplier' => array('model' => 'supplier', 'through' => 'objects_suppliers'),
		'statu' => array('model' => 'statu', 'foreign_key' => 'status_id'),
	);

	public function getAnotacoes($object_id){
		$anotacoes = "";
		$rs = ORM::factory('anotacoes_object')->where('object_id', '=', $object_id)->order_by('id', 'DESC')->find_all();
		foreach ($rs as $anotacao) {
			$anotacoes.= $anotacao->anotacao."\n-------------------\n";
		}

		return $anotacoes;
	}
}