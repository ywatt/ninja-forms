<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Preview extends NF_Abstracts_Controller
{
    private static $transient_prefix = 'nf_form_preview_';

    public function __construct()
    {
        add_action( 'wp_ajax_nf_preview_update', array( $this, 'update' ) );
    }

    public function update()
    {
        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        $form_id = $_POST[ 'form_id' ];

        $form_data = $this->get_form_data( $form_id );

        if( isset( $_POST[ 'field' ] ) ) {

            $field_id = $_POST[ 'field' ][ 'id' ];

            $form_data[ 'fields' ][ $field_id ][ 'settings' ] = $_POST[ 'field' ][ 'settings' ];
        }

        $this->update_form_data( $form_data );

        $this->_data['form'] = $form_data;

        $this->_respond();
    }

    private function get_form_data( $form_id )
    {
        $form_data = get_user_option( self::$transient_prefix . $form_id );

        if( ! $form_data ){

            $form = Ninja_Forms()->form( $form_id )->get();
            $form_data[ 'id' ] = $form_id;
            $form_data[ 'settings' ] = $form->get_settings();

            $fields = Ninja_Forms()->form( $form_id )->get_fields();
            foreach( $fields as $field ){

                $field_id = $field->get_id();
                $form_data[ 'fields' ][ $field_id ][ 'settings' ] = $field->get_settings();
            }
        }

        return $form_data;
    }

    private function update_form_data( $form_data )
    {
        $update = update_user_option( get_current_user_id(), self::$transient_prefix . $form_data['id'], $form_data );

        if( ! $update ){
            // Throw Error
        }
    }
}
