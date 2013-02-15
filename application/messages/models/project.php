<?php defined('SYSPATH') or die('No direct script access.');

return array(
            'name' => array(
                'not_empty' => 'Nome do projeto não pode ser vazio',
               
            ),
			'segmento_id' => array(
                    'not_empty' => 'Segmento do projeto não pode ser vazio',
			),
			'description' => array(
				'not_empty' => 'Descrição do projeto não pode ser vazio',
			),
			'pasta' => array(
				'not_empty' => 'Pasta do projeto não pode ser vazio',
			)
);
// array(array($this, 'name_available'), array(':validation', ':field')),