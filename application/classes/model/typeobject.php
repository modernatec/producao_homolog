<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Typeobject extends ORM {

    protected $_has_many = array(
        'objects' => array('model' => 'object', 'foreign_key' => 'typeobject_id'),
    );
    
	public function rules()
	{
            return array(
                'name' => array(
                    array('not_empty'),
                )
            );
	}

	public function labels()
	{
            return array(
                'name'  => 'Nome',
            );
	}
}