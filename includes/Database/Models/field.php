<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Field
 */
final class NF_Database_Models_Field extends NF_Abstracts_Model
{
    protected $_table_name = 'nf_fields';

    protected $_meta_table_name = 'nf_field_meta';

    protected $_columns = array(
        'title'
    );
    public function __construct( $id )
    {
        parent::__construct( $id );
    }

} // End NF_Database_Models_Field
