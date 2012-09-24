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


	public function labels()
	{
        return array(
            'nome'  => 'Nome',
            'email' => 'Email',
            'foto' => 'Foto',
            'data_aniversario' => 'Data de Aniversário',
        );
	}

	
     
}
