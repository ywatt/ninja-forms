<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Field
 */
abstract class NF_Abstracts_Field
{
  /**
   * @var string
   */
  protected $_name  = '';

  /**
   * @var string
   */
  protected $_group = '';

  /**
   * @var array
   */
  protected $_settings = array();

  /**
   * @var string
   */
  protected $_test_value = '';

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
