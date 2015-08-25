<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Object
 */
final class NF_Database_Models_Object extends NF_BaseClasses_Model
{
    protected $_table_name = 'nf_objects';

    protected $_meta_table_name = 'nf_object_meta';

    protected $_columns = array(
        'type'
    );

    public function __construct( $id )
    {
        parent::__construct( $id );
    }

} // End NF_Database_Models_Object
