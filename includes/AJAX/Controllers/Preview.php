<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Preview extends NF_Abstracts_Controller
{
    public function __construct()
    {
        add_action( 'wp_ajax_nf_preview_form', array( $this, 'form' ) );
        add_action( 'wp_ajax_nf_preview_field', array( $this, 'field' ) );
    }

    public function field()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        $form_id = $_POST[ 'form_id' ];

        $field_id = $_POST[ 'field' ][ 'id' ];

        $transient_string = 'nf_form_preview_' . $form_id;

        $form_data = get_user_option( $transient_string );

        if( ! $form_data ){
            $form = Ninja_Forms()->form( $form_id )->get();
            $form_data[ 'id' ] = $form_id;
            $form_data[ 'settings' ] = $form->get_settings();

            $fields = Ninja_Forms()->form( $form_id )->get_fields();
            foreach( $fields as $field ){
                $form_data[ 'fields' ][ $field->get_id() ][ 'settings' ] = $field->get_settings();
            }
        }

        $form_data[ 'fields' ][ $field_id ][ 'settings' ] = $_POST[ 'field' ][ 'settings' ];

        update_user_option( get_current_user_id(), $transient_string, $form_data );

        $this->_data['form'] = $form_data;

        $this->_respond();
    }
}
