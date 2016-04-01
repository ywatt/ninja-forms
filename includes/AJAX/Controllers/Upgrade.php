<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Upgrade extends NF_Abstracts_Controller
{
    public $upgrades = array();

    public function __construct()
    {
        add_action( 'wp_ajax_nf_ajax_upgrade', array( $this, 'upgrade' ) );
    }

    public function upgrade()
    {
//        check_ajax_referer( 'ninja_forms_ajax_nonce', 'security' );

        if( ! isset( $_POST[ 'form_id' ] ) || ! $_POST[ 'form_id' ] ){
            $this->_errors[] = __( 'Form not found', 'ninja-forms' );
            $this->_respond();
        }

        $form_id = absint( $_POST[ 'form_id' ] );
        $form = Ninja_Forms()->form( $form_id )->get();

        $form_settings = apply_filters( 'ninja_forms_upgrade_settings', $form->get_settings() );
        $form->update_settings( $form_settings );

        foreach( Ninja_Forms()->form( $form_id )->get_fields() as $field ){
            $type = $field->get_type();
            $settings = apply_filters( 'ninja_forms_upgrade_field_' . $type, $field->get_settings() );
            $field->update_settings( $settings )->save();
        }

        foreach( Ninja_Forms()->form( $form_id )->get_actions() as $action ){
            $type = $action->get_setting( 'type' );
            $this->_data[ 'action_types' ][] = $type;
            $settings = apply_filters( 'ninja_forms_upgrade_action_' . $type, $action->get_settings() );
            $action->update_settings( $settings )->save();
        }

        $this->_errors[] = 'test';

        $this->_data[ 'form_id' ] = $form_id;
        $this->_data[ 'form' ] = $form->get_settings();

        $this->_respond();
    }
        
} // END CLASS NF_AJAX_Controllers_Upgrade
