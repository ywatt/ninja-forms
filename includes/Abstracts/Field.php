<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ModelFactory
 */
abstract class NF_Abstracts_Field
{
  /**
   * @var string
   */
  protected $name  = '';

  /**
   * @var string
   */
  protected $group = '';

  /**
   * @var array
   */
  protected $settings = array();

  /**
   * @var string
   */
  protected $test_value = '';

  /**
   * Constructor
   */
  public function __construct()
  {

  }

  /*
   * PUBLIC METHODS
   */
  public function register()
  {

  }

  public abstract function validate();

  public abstract function process();

}
