<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
    'native' => array(
        'name' => 'kaizen_auth',
        'lifetime' => 0,
    ),
    'cookie' => array(
        'name' => 'kaizen_auth',
        'encrypted' => TRUE,
        'lifetime' => 0,
    ),
    'database' => array(
        'name' => 'kaizen_auth',
        'encrypted' => TRUE,
        'lifetime' => 0,
        'group' => 'default',
        'table' => 'table_name',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);