<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Submission
 */
final class NF_Database_Models_Submission
{
    protected $_db = '';

    protected $_id = '';

    protected $_form_id = '';

    public function __construct( $db, $id = '', $form_id = '' )
    {
        $this->_db = $db;
        $this->_id = $id;
        $this->_form_id = $form_id;
    }

    /**
     * Find
     *
     * @param array $where
     * @return array
     */
    public function find( $where = array() )
    {
        $args = array(
            'post_type' => 'nf_sub',
            'posts_per_page' => -1,
            'meta_query' => format_meta_query( $where )
        );

        return get_posts( $args );
    }

    /*
     * UTILITIES
     */

    /**
     * Format Meta Query
     *
     * @param array $where
     * @return array
     */
    protected function format_meta_query( $where = array() )
    {
        $return = array();

        foreach( $where as $key => $value ){

            $return[] = ( is_array( $value ) ) ? $value : array( 'key' => $key, 'value' => $value );
        }

        return $return;
    }


} // End NF_Database_Models_Submission
