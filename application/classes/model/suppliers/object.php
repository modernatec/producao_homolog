<?php defined('SYSPATH') or die('No direct script access.');

class Model_Suppliers_Object extends ORM {

    protected $_belongs_to = array(
        'team' => array('foreign_key' => 'team_id'),
    );

}
