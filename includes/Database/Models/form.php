<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Model_Form extends NF_BaseClasses_Model
{
    public $table_name = 'nf_forms';

    public $meta_table_name = 'nf_form_meta';

    public $columns = array();

    public function __construct( $id )
    {
        parent::__construct( $id );
    }

}