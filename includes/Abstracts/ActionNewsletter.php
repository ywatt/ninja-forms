<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ActionNewsletter
 */
abstract class NF_Abstracts_ActionNewsletter extends NF_Abstracts_Action
{
    /**
     * @var array
     */
    protected $_tags = array( 'newsletter' );

    /**
     * @var string
     */
    protected $_timing = 'normal';

    /**
     * @var int
     */
    protected $_priority = '10';

    protected $_settings = array();

    protected $_transient = '';

    protected $_transient_expiration = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        add_action( 'wp_ajax_nf_' . $this->_name . '_get_lists', array( $this, '_get_lists' ) );

        $this->get_list_settings();
    }

    /*
    * PUBLIC METHODS
    */

    public function save( $action_settings )
    {

    }

    public function process( $action_settings, $form_id, $data )
    {

    }

    public function _get_lists()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        $lists = $this->get_lists();

        array_unshift( $lists, array( 'value' => 0, 'label' => '-', 'fields' => array(), 'groups' => array() ) );

        $this->cache_lists( $lists );

        echo wp_json_encode( array( 'lists' => $lists ) );

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    /*
     * PROTECTED METHODS
     */

    abstract protected function get_lists();

    /*
     * PRIVATE METHODS
     */

    private function get_list_settings()
    {
        $lists = get_transient( $this->_transient );

        if( ! $lists ) {
            $lists = $this->get_lists();
            $this->cache_lists( $lists );
        }

        if( empty( $lists ) ) return;

        $this->_settings[ 'newsletter_list' ] = array(
            'name' => 'newsletter_list',
            'type' => 'select',
            'label' => __( 'List', 'ninja-forms' ) . ' <a class="js-newsletter-list-update extra"><span class="dashicons dashicons-update"></span></a>',
            'width' => 'full',
            'group' => 'primary',
            'value' => '0',
            'options' => array(),
        );

        $fields = array();
        foreach( $lists as $list ){
            $this->_settings[ 'newsletter_list' ][ 'options' ][] = $list;

            foreach( $list[ 'fields' ] as $field ){
                $name = $list[ 'value' ] . '_' . $field[ 'value' ];
                $fields[] = array(
                    'name' => $name,
                    'type' => 'textbox',
                    'label' => $field[ 'label' ],
                    'width' => 'full',
                    'use_merge_tags' => array(
                        'exclude' => array(
                            'user', 'post', 'system', 'querystrings'
                        )
                    )
                );
            }
        }

        $this->_settings[ 'newsletter_list_fields' ] = array(
            'name' => 'newsletter_list_fields',
            'label' => __( 'List Field Mapping', 'ninja-forms' ),
            'type' => 'fieldset',
            'group' => 'primary',
            'settings' => []
        );

        $this->_settings[ 'newsletter_list_groups' ] = array(
            'name' => 'newsletter_list_groups',
            'label' => __( 'Interest Groups', 'ninja-forms' ),
            'type' => 'fieldset',
            'group' => 'primary',
            'settings' => []
        );
    }

    private function cache_lists( $lists )
    {
        set_transient( $this->_transient, $lists, $this->_transient_expiration );
    }
}
