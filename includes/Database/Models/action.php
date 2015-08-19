<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Model_Action extends NF_BaseClasses_Model
{
    public $table_name = 'nf_actions';

    public $meta_table_name = 'nf_action_meta';

    public $columns = array();

    public function __construct( $id )
    {
        parent::__construct( $id );
    }

}