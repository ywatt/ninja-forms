<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Model_Field extends NF_BaseClasses_Model
{
    public $table_name = 'nf_fields';

    public $meta_table_name = 'nf_field_meta';

    public $columns = array();

    public function __construct( $id )
    {
        parent::__construct( $id );
    }

}