<?php defined('SYSPATH') or die('No direct script access.');

class Model_Project extends ORM {

	public function rules()
	{
        return array(
            'name' => array(
                array('not_empty'),
            ),
            'target' => array(
                array('not_empty'),
            ),
        );
	}

	public function labels()
	{
            return array(
                'name'  => 'Projeto',
                'target' => 'Seguimento',
                'description' => 'Descrição',
                'pasta' => 'Pasta',
            );
	}     
}