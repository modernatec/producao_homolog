<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Tasks_User extends ORM {
	//static $belongs_to = array('estado');
	protected $_belongs_to = array(
    	'task' => array('foreign_key' => 'task_id'),
    	'user' => array('foreign_key' => 'user_id'),
    );
}