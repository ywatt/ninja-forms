<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Models_Form extends NF_BaseClasses_Model
{
    public $table_name = 'nf_forms';

    public $meta_table_name = 'nf_form_meta';

    public $columns = array(
        'title'
    );

    public function __construct( $id )
    {
        parent::__construct( $id );
    }

}