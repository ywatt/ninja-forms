<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Form
 */
final class NF_Database_Models_Form extends NF_Abstracts_Model
{
    protected $_table_name = 'nf_forms';

    protected $_meta_table_name = 'nf_form_meta';

    protected $_columns = array(
        'title'
    );

    protected $_fields;

    public function __construct( $db, $id = '' )
    {
        parent::__construct( $db, $id );

        $this->getFields();
    }

    public function delete()
    {
        parent::delete();

        $fields = $this->fields();
    }

    private function getFields()
    {

    }

} // End NF_Database_Models_Form
