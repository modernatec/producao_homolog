<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Status_Task extends ORM {
	//static $belongs_to = array('estado');
	protected $_belongs_to = array(
    	'task' => array(),
    	'user' => array(),
    	'statu' => array('model' => 'statu', 'foreign_key' => 'status_id'),
    );

	protected $_has_many = array(
    	'files' => array('model' => 'file', 'foreign_key' => 'status_task_id'),
    );    
}