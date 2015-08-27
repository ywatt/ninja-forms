<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ModelFactory
 */
class NF_Abstracts_ModelFactory
{
    public $form;

    public $fields = array();

    public $actions = array();

    public function form( $id )
    {
        $this->form = new NF_Database_Models_Form( $id );

        return $this;
    }

    public function get_form( $id )
    {
        return $this->form = new NF_Database_Models_Form( $id );
    }

    public function get_field( $id )
    {
        $form_id = $this->form->get_id();

        return $this->fields[ $id ] = new NF_Database_Models_Field( $id, $form_id );
    }

    public function get_fields()
    {
        return $this->fields;
    }

    public function get_action( $id )
    {
        $form_id = $this->form->get_id();

        return $this->actions[ $id ] = new NF_Database_Models_Action( $id, $form_id );
    }

    public function get_actions()
    {
        return $this->actions;
    }

} // End Class NF_Abstracts_ModelFactory

//function NF()
//{
//    return new NF_ModelFactory();
//}

// NF()->get_form( 1 );
// NF()->form( 1 )->get_fields();
// NF()->form( 1 )->get_field( 2 );
// NF()->form( 1 )->get_actions();
// NF()->form( 1 )->get_action( 3 );