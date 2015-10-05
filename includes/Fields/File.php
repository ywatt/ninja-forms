<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Field_File
 */
class NF_Fields_File extends NF_Abstracts_Input
{
    const TEMPLATE = 'file';

    protected $_name = 'file';

    protected $_nicename = 'File';

    protected $_group = 'standard_fields';

    protected $_type = 'file';

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'File', Ninja_Forms::TEXTDOMAIN );
    }
}
