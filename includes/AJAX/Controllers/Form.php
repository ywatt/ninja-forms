<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_Form extends NF_BaseClasses_Controller
{
    public $form = '';

    public function __construct()
    {
        add_action( 'wp_ajax_nf_save_form',   array( $this, 'save' )   );
        add_action( 'wp_ajax_nf_delete_form', array( $this, 'delete' ) );
    }

    public function save()
    {
        //TODO: Abstract
        if( isset( $_POST['nf_form'] ) ) {
            $this->form = $_POST['nf_form'];
        } else {
            json_encode( array( 'error' => 'No Form Object Found' ) );
            wp_die();
        }

        $form_model = new NF_Database_Models_Form( 1 );

        $result = $form_model->update_settings( $this->form['form_settings'] );

        if ( false === $result ) $this->errors[] = $result;

        $response = array( 'errors' => $this->errors, 'settings' => $this->form['form_settings'] );

        echo json_encode( $response );

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function delete()
    {
        //TODO: Abstract
        if( isset( $_POST['nf_form'] ) ) {
            $this->form = $_POST['nf_form'];
        } else {
            json_encode( array( 'error' => 'No Form Object Found' ) );
            wp_die();
        }

        $form = new NF_Database_Models_Form( 1 );
        $result = $form->delete();

        if ( false === $result ) $this->errors[] = $result;

        $response = array( 'errors' => $this->errors, 'settings' => $this->form['form_settings'] );

        echo json_encode( $response );

        wp_die(); // this is required to terminate immediately and return a proper response
    }
}
