<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Action
 */
final class NF_Database_Models_Action extends NF_Abstracts_Model
{
    protected $_table_name = 'nf_actions';

    protected $_meta_table_name = 'nf_action_meta';

    protected $_columns = array();

    public function __construct( $id )
    {
        parent::__construct( $id );
    }

} // End NF_Database_Models_Action
