<?php defined('SYSPATH') or die('No direct script access.');

return array(
            'name' => array(
                'not_empty' => 'Nome do projeto não pode ser vazio',
                array(array($this, 'name_available'), array(':validation', ':field')),
            ),
);
