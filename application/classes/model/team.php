<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Team extends ORM {
	//static $belongs_to = array('estado');
	protected $_belongs_to = array(
		'userInfo'       => array('model' => 'userInfo', 'foreign_key' => 'userInfo_id'),
	);

	protected $_has_many = array(
		'userInfos'       => array('model' => 'userInfo', 'foreign_key' => 'team_id'),
	);
        
    public function rules()
	{
            return array(
                'name' => array(
                    array('not_empty'),                    
                ),
				'userInfo_id' => array(
                    array('not_empty'),                    
                )
            );
	}

	public function labels()
	{
            return array(
                'name'  => 'Equipe',
				'userInfo_id'  => 'Coordenador',
            );
	}
}
