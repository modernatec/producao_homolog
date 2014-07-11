<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Tag extends ORM {
	//static $belongs_to = array('estado');
	protected $_belongs_to = array(
		'task'       => array('model' => 'task', 'foreign_key' => 'task_id'),
	);
    
    public function rules()
	{
            return array(
                'tag' => array(
                    array('not_empty'),                    
                ),
				'type' => array(
                    array('not_empty'),                    
                )
            );
	}

	public function labels()
	{
            return array(
                'tag'  => 'Tag',
				'type'  => 'Model da tag',
            );
	}
}
