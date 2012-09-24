<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Priority extends ORM {
		
	protected $_has_one = array(
		'task' => array('model' => 'task', 'foreign_key' => 'priority_id')
	);
	
}
