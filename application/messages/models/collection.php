<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'name' => array(
        'not_empty' => 'O nome da coleção não pode ser vazio',
        'unique_collection' => 'Já existe uma coleção com este nome',
    ),
);
// array(array($this, 'name_available'), array(':validation', ':field')),