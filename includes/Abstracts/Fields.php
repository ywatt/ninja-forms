<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_Abstracts_Fields
{

  public $name  = '';

  public $group = '';

  public $settings = array();

  public $test_value = '';

  public function __construct()
  {

  }

  public function register()
  {

  }

  abstract public function validate();

  abstract public function process();

}
