<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Donation
 */
class NF_Fields_Donation extends NF_Fields_Textbox
{
    protected $_name = 'donation';

    protected $_nicename = 'Donation';

    protected $_section = 'pricing';

    protected $_icon = 'tag';

    protected $_type = 'textbox';

    protected $_templates = 'textbox';
    
    protected $_settings_exclude = array( 'input_limit_set', 'disable_input',
                                          'disable_browser_autocomplete', 'mask', 'custom_mask' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Donation', 'ninja-forms' );
    }
}
