<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_ProductOptions
 */
class NF_Fields_ProductOptions extends NF_Abstracts_List
{
    protected $_name = 'productoptions';

    protected $_type = 'productoptions';

    protected $_nicename = 'Product Options';

    protected $_section = 'pricing';

    protected $_icon = 'tags';

    protected $_templates = array( 'listselect', 'listradio', 'listcheckbox' );
    
    protected $_settings = array( 'product_assignment', 'options_display_as' );

    public function __construct()
    {
        parent::__construct();

        $options = $this->_settings['options'];

        unset($this->_settings['options']);

        $this->_settings['options'] = $options;

        $this->_nicename = __( 'Product Options', 'ninja-forms' );

        add_filter( 'ninja_forms_merge_tag_calc_value_' . $this->_type, array( $this, 'get_calc_value' ), 10, 2 );
    }

    public function get_calc_value( $value, $field )
    {
        if( isset( $field[ 'options' ] ) ) {
            foreach ($field['options'] as $option ) {
                if( ! isset( $option[ 'value' ] ) || $value != $option[ 'value' ] || ! isset( $option[ 'calc' ] ) ) continue;
                return $option[ 'calc' ];
            }
        }
        return $value;
    }
}
