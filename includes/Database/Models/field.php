<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Field
 */
final class NF_Database_Models_Field extends NF_Abstracts_Model
{
    private $form_id = '';

    protected $_table_name = 'nf_fields';

    protected $_meta_table_name = 'nf_field_meta';

    protected $_columns = array(
        'title'
    );
    public function __construct( $db, $id, $form_id )
    {
        $this->form_id = $form_id;

        parent::__construct( $db, $id );
    }

} // End NF_Database_Models_Field
