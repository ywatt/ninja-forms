<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Form
 */
final class NF_Database_Models_Form extends NF_BaseClasses_Model
{
    protected $_table_name = 'nf_forms';

    protected $_meta_table_name = 'nf_form_meta';

    protected $_columns = array(
        'title'
    );

    protected $_fields;

    public function __construct( $id )
    {
        parent::__construct( $id );

        $this->getFields();
    }

    public function delete()
    {
        parent::delete();

        $fields = $this->fields();
    }

    private function getFields()
    {
        $this->fields = NF::field()->find( array( 'form_id' => $this->id ) );
    }

} // End NF_Database_Models_Form
