<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Arm Auth Role Model.
 *
 * @package    Arm Auth
 * @author     Devi Mandiri <devi.mandiri@gmail.com>
 * @copyright  (c) 2011 Devi Mandiri
 * @license    MIT
 */
class Model_Contact extends ORM {

	public function rules()
	{
            return array(
                'nome' => array(
                    array('not_empty'),
                ),
                'email' => array(
                    array('not_empty'),
                ),
                'telefone' => array(
                    array('not_empty'),
                )
            );
	}

	public function labels()
	{
            return array(
                'name'  => 'Contato',
                'email' => 'Email',
                'telefone' => 'Telefone',
                'site' => 'Site',
                'empresa' => 'Empresa',
            );
	}
}
