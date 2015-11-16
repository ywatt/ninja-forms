<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_List
 */
abstract class NF_Abstracts_List extends NF_Abstracts_Field
{
    protected $_name = '';

    protected $_section = 'common';

    protected $_type = 'list';

    public static $_base_template = 'list';

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'required', 'options', 'classes' )
        );
    }

    public function get_parent_type()
    {
        return parent::get_type();
    }
}
