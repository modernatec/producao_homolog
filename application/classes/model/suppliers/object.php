<?php defined('SYSPATH') or die('No direct script access.');

class Model_Suppliers_Object extends ORM {

    protected $_belongs_to = array(
        'supplier' => array('foreign_key' => 'supplier_id'),
    );

    public function filters()
	{
		return array(
			'amount' => array(
				array(array($this, 'setup_decimal'))
			),
		);
	}

	public function setup_decimal($value)
	{
		$r = str_replace('.', '', $value);
		return str_replace(',', '.', $r);
    }

}
