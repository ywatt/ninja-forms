<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Field
 */
final class NF_Database_Models_Field extends NF_Abstracts_Model
{
    private $form_id = '';

    protected $_type = 'field';

    protected $_table_name = 'nf3_fields';

    protected $_meta_table_name = 'nf3_field_meta';

    protected $_columns = array(
        'label',
        'key',
        'parent_id',
        'type',
        'created_at'
    );
    public function __construct( $db, $id, $parent_id = '' )
    {
        parent::__construct( $db, $id, $parent_id );
    }

} // End NF_Database_Models_Field
