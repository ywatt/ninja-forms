<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_MockData extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Mock Data';

    public $priority = 9002;

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        echo '<div class="wrap">Hello, migrations!</div>';

        /*
         * Migrations
         */
        $migrations = new NF_Database_Migrations();
        $migrations->nuke( TRUE, TRUE );

        $posts = get_posts( 'post_type=nf_sub&numberposts=-1' );
        foreach( $posts as $post ){
            wp_delete_post( $post->ID, TRUE );
        }

        $migrations->migrate();

        /*
         * Create Form
         */
        $form = Ninja_Forms()->form()->get();
        $form->update_setting( 'title', 'Contact Me' );
        $form->save();

        $form = Ninja_Forms()->form()->get();
        $form->update_setting( 'title', 'Get Help' );
        $form->save();

        /*
         * Create Field
         */

        /* FORM #1: Contact Me */

        $field = Ninja_Forms()->form( 1 )->field()->get();
        $field->update_setting( 'type', 'textbox' )
            ->update_setting( 'label', 'Name')
            ->update_setting( 'label_pos', 'above' )
            ->update_setting( 'required', 1 )
            ->update_setting( 'order', 1 )
            ->save();

        $name_field_id = $field->get_id();

        $field = Ninja_Forms()->form( 1 )->field()->get();
        $field->update_setting( 'type', 'email' )
            ->update_setting( 'label', 'Email')
            ->update_setting( 'label_pos', 'above' )
            ->update_setting( 'required', 1 )
            ->update_setting( 'order', 2 )
            ->save();

        $email_field_id = $field->get_id();

        // $field = Ninja_Forms()->form( 1 )->field()->get();
        // $field->update_setting( 'type', 'textbox' )
        //     ->update_setting( 'label', 'Confirm Email')
        //     ->update_setting( 'label_pos', 'above' )
        //     ->update_setting( 'confirm_field', $email_field_id )
        //     ->update_setting( 'required', 1 )
        //     ->update_setting( 'order', 3 )
        //     ->save();

        $field = Ninja_Forms()->form( 1 )->field()->get();
        $field->update_setting( 'type', 'textarea' )
            ->update_setting( 'label', 'Message')
            ->update_setting( 'label_pos', 'above' )
            ->update_setting( 'required', 1 )
            ->update_setting( 'order', 3 )
            ->save();

        // $field = Ninja_Forms()->form( 1 )->field()->get();
        // $field->update_setting( 'type', 'textbox' )
        //     ->update_setting( 'label', 'Mirror Name')
        //     ->update_setting( 'label_pos', 'above' )
        //     ->update_setting( 'required', 1 )
        //     ->update_setting( 'mirror_field', $name_field_id )
        //     ->update_setting( 'order', 5 )
        //     ->save();

        $options = array(
            array(
                'label' => 'One',
                'value' => '1',
                'calc' => 1
            ),
            array(
                'label' => 'Two',
                'value' => '2',
                'calc' => 2
            ),
            array(
                'label' => 'Three',
                'value' => '3',
                'calc' => 3
            ),
        );

        $field = Ninja_Forms()->form( 1 )->field()->get();
        $field->update_setting( 'type', 'listradio' )
            ->update_setting( 'label', 'Jame\'s List')
            ->update_setting( 'options', $options)
            ->update_setting( 'order', 5 )
            ->save();

        $field = Ninja_Forms()->form( 1 )->field()->get();
        $field->update_setting( 'type', 'submit' )
            ->update_setting( 'label', 'Submit')
            ->update_setting( 'order', 6 )
            ->save();

        /* FORM #2: Get Help */

        $fields = array(
            array(
                'id'			=> 4,
                'type' 			=> 'textbox',
                'label'			=> 'Name',
                'label_pos' 	=> 'above',
                'order'         => 1,
            ),
            array(
                'id'			=> 12,
                'type'			=> 'email',
                'label'			=> 'Email',
                'label_pos'		=> 'above',
                'order'         => 2,
            ),
            array(
                'id'			=> 5,
                'type' 			=> 'textarea',
                'label'			=> 'What Can We Help You With?',
                'label_pos'		=> 'above',
                'order'         => 3,
            ),
            array(
                'id'			=> 6,
                'type' 			=> 'checkbox',
                'label'			=> 'Agree?',
                'label_pos'		=> 'right',
                'order'         => 4,
            ),
            array(
                'id'			=> 9,
                'type' 			=> 'listradio',
                'label'			=> 'Best Contact Method?',
                'label_pos'		=> 'above',
                'options'		=> array(
                    array(
                        'label'	=> 'Phone',
                        'value'	=> 'phone',
                        'calc'  => '',
                    ),
                    array(
                        'label'	=> 'Email',
                        'value'	=> 'email',
                        'calc'  => '',
                    ),
                    array(
                        'label'	=> 'Snail Mail',
                        'value'	=> 'snail-mail',
                        'calc'  => '',
                    ),
                ),
                'show_other'	=> 1,
                'required'      => 1,
                'order'         => 5,
            ),
            array(
                'id'			=> 7,
                'type'			=> 'submit',
                'label'			=> 'Send',
                'order'         => 6,
            )
        );

        foreach( $fields as $settings ){

            unset( $settings[ 'id' ] );

            $field = Ninja_Forms()->form( 2 )->field()->get();
            $field->update_settings( $settings )->save();
        }

        /*
         * Create Submission
         */

        $sub = Ninja_Forms()->form( 1 )->sub()->get();
        $sub->update_field_value( 1, 'Kyle Johnson' )
            ->update_field_value( 2, 'kyle@wpninjas.com' )
            ->update_field_value( 3, 'kyle@wpninjas.com' )
            ->update_field_value( 4, 'This is a test.' )
            ->update_field_value( 5, 'Kyle Johnson' );
        $sub->save();

        // Delay Execution for different submission dates
        sleep(1);

        $sub = Ninja_Forms()->form( 1 )->sub()->get();
        $sub->update_field_value( 1, 'John Doe' )
            ->update_field_value( 2, 'user@gmail.com' )
            ->update_field_value( 3, 'user@gmail.com' )
            ->update_field_value( 4, 'This is another test.' )
            ->update_field_value( 5, 'John Doe' );
        $sub->save();


        /*
         * Create Field from Array
         */

//        $json = array(
//            'settings' => array(
//                'title' => 'Mock Field 2',
//                'type' => 'checkbox',
//                'foo' => 'bar',
//                'baz' => 'qux'
//            )
//        );
//
//        Ninja_Forms()->form( 1 )->field()->get()->update_settings( $json['settings'] )->save();


        /*
         * CREATE OBJECT
         */

//        $object = Ninja_Forms()->form( 1 )->object()->get();
//        $object->update_setting( 'foo', 'bar' )->save();
//
//        $object = Ninja_Forms()->form()->field()->object()->get();
//        $object->update_setting( 'foo', 'bar' )->add_parent( 1, 'form' )->save();

        /*
         * CREATE ACTION
         */
        $action = Ninja_Forms()->form( 1 )->action()->get();
        $action->update_setting( 'title',  'Mock Success Message Action' )
            ->update_setting( 'type', 'successmessage' )
            ->update_setting( 'message', 'This is a test success message' )
            ->save();

        $action = Ninja_Forms()->form( 1 )->action()->get();
        $action->update_setting( 'title',  'Mock Redirect Action' )
            ->update_setting( 'type', 'redirect' )
            ->update_setting( 'url', 'http://kstover.codes' )
            ->update_setting( 'active', 0 )
            ->save();

        $action = Ninja_Forms()->form( 1 )->action()->get();
        $action->update_setting( 'title',  'Mock Email Action' )
            ->update_setting( 'type', 'email' )
            ->update_setting( 'to', array( 'kyle@wpninjas.com' ) )
            ->update_setting( 'subject', 'This is an email action.' )
            ->update_setting( 'message', 'Hello, Ninja Forms!' )
            ->update_setting( 'active', FALSE )
            ->save();

        $action = Ninja_Forms()->form( 1 )->action()->get();
        $action->update_setting( 'title',  'Run WordPress Action' )
            ->update_setting( 'type', 'custom' )
            ->update_setting( 'hook', 'action' )
            ->update_setting( 'tag', 'blarg_action' )
            ->save();

        $action = Ninja_Forms()->form( 1 )->action()->get();
        $action->update_setting( 'title',  'Mock Save Action' )
            ->update_setting( 'type', 'save' )
            ->save();

        $action = Ninja_Forms()->form( 2 )->action()->get();
        $action->update_setting( 'title',  'Mock Save Action' )
            ->update_setting( 'type', 'save' )
            ->save();

        /*
         * Find Fields
         */

        echo "<h3>Fields</h3>";

        global $wpdb;

        $fields = Ninja_Forms()->form( 1 )->get_fields();
//        $fields = Ninja_Forms()->form( 1 )->get_fields( [ 'foo' => 'bar' ] );

        foreach( $fields as $field ){
            echo "<pre>";
            var_dump($field->get_settings());
            echo "</pre>";
        }

        /*
         * Find Actions
         */

        echo "<h3>Actions</h3>";

        global $wpdb;

        $actions = Ninja_Forms()->form( 1 )->get_actions();

        foreach( $actions as $action ){
            echo "<pre>";
            var_dump($action->get_settings());
            echo "</pre>";
        }

        /*
         * SHORTCODE
         */

//        echo "<h2>SHORTCODE OUTPUT</h2>";
//
//        do_shortcode( '[nf_tmp_frontend form_id="1"]' );

    }

} // End Class NF_Admin_Settings
