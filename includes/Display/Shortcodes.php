<?php

final class NF_Display_Shortcodes
{
    public function __construct()
    {
        add_shortcode( 'ninja_form',  array( $this, 'display_form_front_end' ) );
        add_shortcode( 'ninja_forms', array( $this, 'display_form_front_end' ) );

        add_shortcode( 'ninja_forms_view', array( $this, 'ninja_forms_view' ) );
    }

    public function display_form_front_end( $atts = array() )
    {
        if( ! isset( $atts[ 'id' ] ) ) return $this->display_no_id();

        ob_start();
        Ninja_Forms()->display( $atts['id'] );
        return ob_get_clean();
    }

    /**
     * TODO: Extract output to template files.
     * @return string
     */
    private function display_no_id()
    {
        $output = __( 'Notice: Ninja Forms shortcode used without specifying a form.', 'ninja-forms' );

        // TODO: Maybe support filterable permissions.
        if( ! current_user_can( 'manage_options' ) ) return "<!-- $output -->";

        // TODO: Log error for support reference.
        // TODO: Maybe display notice if not logged in.
        trigger_error( 'Ninja Forms shortcode used without specifying a form.' );

        return "<div style='border: 3px solid red; padding: 1em; margin: 1em auto;'>$output</div>";
    }

    function ninja_forms_view( $atts = array() )
    {
        $id = $atts['id'];

        $form = Ninja_Forms()->form( $id )->get();
        $fields = Ninja_Forms()->form( $id )->get_fields();

        $subs = Ninja_Forms()->form( $id )->get_subs();


        echo $form->get_setting( 'sub_view_before' );
        foreach( array_reverse( $subs ) as $sub ){

            $merge_tags = Ninja_Forms()->merge_tags[ 'fields' ];
            foreach( $fields as $field ){

                $field_id = $field->get_id();

                $merge_tags->add_field( array(
                    'id' => $field->get_id(),
                    'key' => $field->get_setting( 'key' ),
                    'type' => $field->get_type(),
                    'value' => $sub->get_field_value( $field_id )
                ));
            }

            echo apply_filters( 'kbj_test', $form->get_setting( 'sub_view' ) );
        }
        echo $form->get_setting( 'sub_view_after' );
    }
}
