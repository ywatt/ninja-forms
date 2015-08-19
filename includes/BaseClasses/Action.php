<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_BaseClasses_Action
{
    public $timing = 'normal';

    public $priority = '10';

    public function __construct()
    {

    }

    public abstract function process();
}
