<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Submissions extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Submissions';

    public $menu_slug = 'edit.php?post_type=nf_subs';

    public $function = NULL;

    public function __construct()
    {
        parent::__construct();

        add_filter( 'manage_nf_subs_posts_columns', array( $this, 'change_columns' ) );

        add_action( 'manage_posts_custom_column', array( $this, 'custom_columns' ), 10, 2 );
    }

    public function display()
    {
        // This section intentionally left blank.
    }

    public function change_columns(  )
    {
        $cols = array(
            'cb'    => '<input type="checkbox" />',
            'id' => __( '#', 'ninja-forms' ),
        );

        $fields = Ninja_Forms()->form( 1 )->get_fields();

        foreach( $fields as $field ){

            $cols[ 'field_' . $field->get_id() ] = $field->get_setting( 'label' );
        }

        $cols[ 'sub_date' ] = __( 'Date', 'ninja-forms' );

        return $cols;
    }

    public function custom_columns( $column, $sub_id )
    {
        $sub = Ninja_Forms()->form()->get_sub( $sub_id );

        switch( $column ){
            case 'id':
                echo $this->custom_columns_id( $sub );
                break;
            case 'sub_date':
                echo $this->custom_columns_sub_date( $sub );
                break;
            default:
                echo $this->custom_columns_field( $sub, $column );
        }
    }

    private function custom_columns_id( $sub )
    {
        return $sub->get_id();
    }

    private function custom_columns_sub_date( $sub )
    {
        return $sub->get_sub_date();
    }

    private function custom_columns_field( $sub, $column )
    {
        if( FALSE === strpos( $column, 'field_' ) ) return FALSE;

        $field_id = str_replace( 'field_', '', $column );

        return $sub->get_field_value( $field_id );
    }

}
