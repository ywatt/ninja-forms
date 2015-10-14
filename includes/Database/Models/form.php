<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Database_Models_Form
 */
final class NF_Database_Models_Form extends NF_Abstracts_Model
{
    protected $_type = 'form';

    protected $_table_name = 'nf_forms';

    protected $_meta_table_name = 'nf_form_meta';

    protected $_columns = array(
        'title'
    );

    protected $_fields;

    public function __construct( $db, $id = '' )
    {
        parent::__construct( $db, $id );
    }

    public function delete()
    {
        parent::delete();

        $fields = Ninja_Forms()->form( $this->_id )->get_fields();

        foreach( $fields as $field ){
            $field->delete();
        }

        $actions = Ninja_Forms()->form( $this->_id )->get_actions();

        foreach( $actions as $action ){
            $action->delete();
        }
    }

    public static function get_next_sub_seq( $form_id )
    {
        $form = Ninja_Forms()->form( $form_id )->get();

        $last_seq_num = $form->get_setting( '_seq_num', 1 );

        $form->update_setting( '_seq_num', $last_seq_num + 1 )->save();

        return $last_seq_num;
    }

} // End NF_Database_Models_Form
