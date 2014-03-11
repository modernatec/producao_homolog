<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_UserInfo extends ORM {

    protected $_belongs_to  = array(
        'user' => array('model' => 'user', 'foreign_key' => 'user_id'),
        'team'       => array('model' => 'team', 'foreign_key' => 'team_id'),
    );
    

    public function labels()
    {
        return array(
            'nome'  => 'Nome',
            'email' => 'Email',
            'foto' => 'Foto',
            'data_aniversario' => 'Data de Aniversário',
            'username' => 'Username',
            'password' => 'Senha',
            'role' => 'Permissão',
        );
    }
    
    public function filters()
    {
            return array(
                    'data_aniversario' => array(
                            array(array($this, 'setup_date'))
                    )
            );
    }
    
    public function setup_date($value)
    {
        if($value != ''){
            $data = explode('/',$value);
            return  '2000-'.$data[1].'-'.$data[0];
        }else{
            return  NULL;
        }
    }
     
}
