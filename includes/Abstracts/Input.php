<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_Input
 */
abstract class NF_Abstracts_Input extends NF_Abstracts_Field
{
    protected $_name = 'input';

    protected $_section = 'common';

    protected $_type = 'text';

    public function __construct()
    {
        parent::__construct();

    }

    public function get_parent_type()
    {
        return parent::get_type();
    }
}
