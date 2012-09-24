<?php defined('SYSPATH') or die('No direct script access.');
class Request extends Kohana_Request
{
  public function execute()
  {
    $this->action(str_replace('-', '', $this->action()));
    $this->controller(str_replace('-', '', $this->controller()));
    return parent::execute();
  }
}