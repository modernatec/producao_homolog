<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Statu extends ORM {
	//static $belongs_to = array('estado');

	protected $_has_many = array(
		'tasks' => array('through' => 'status_tasks'),
		'taskflows' => array('model' => 'taskflow'),
	);
}
