<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Admin_Menus_Submissions
 */
final class NF_Admin_Menus_Submissions extends NF_Abstracts_Submenu
{
    /**
     * @var string
     */
    public $parent_slug = 'ninja-forms';

    /**
     * @var string
     */
    public $page_title = 'Submissions';

    /**
     * @var string
     */
    public $menu_slug = 'edit.php?post_type=nf_subs';

    /**
     * @var null
     */
    public $function = NULL;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        add_filter( 'manage_nf_subs_posts_columns', array( $this, 'change_columns' ) );

        add_action( 'manage_posts_custom_column', array( $this, 'custom_columns' ), 10, 2 );

        add_filter('months_dropdown_results', array( $this, 'remove_filter_show_all_dates' ), 9999 );

        add_action( 'restrict_manage_posts', array( $this, 'add_filters' ) );

        add_filter( 'parse_query', array( $this, 'table_filter' ) );

        add_filter( 'posts_clauses', array( $this, 'search' ), 20, 1 );

        add_filter( 'bulk_actions-edit-nf_sub', array( $this, 'remove_bulk_edit' ) );
    }

    /**
     * Display
     */
    public function display()
    {
        // This section intentionally left blank.
    }

    /**
     * Change Columns
     *
     * @return array
     */
    public function change_columns()
    {
        $cols = array(
            'cb'    => '<input type="checkbox" />',
            'id' => __( '#', 'ninja-forms' ),
        );

        $fields = Ninja_Forms()->form( 1 )->get_fields();

        $hidden_field_types = apply_filters( 'nf_sub_hidden_field_types', array() );

        foreach( $fields as $field ){

            if( in_array( $field->get_setting( 'type' ), $hidden_field_types ) ) continue;

            // TODO: Add support for 'Admin Labels'
            $cols[ 'field_' . $field->get_id() ] = $field->get_setting( 'label' );
        }

        $cols[ 'sub_date' ] = __( 'Date', 'ninja-forms' );

        return $cols;
    }

    /**
     * Custom Columns
     *
     * @param $column
     * @param $sub_id
     */
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

    /**
     * Remove Filter: Show All Dates
     *
     * @param $months
     * @return array
     */
    public function remove_filter_show_all_dates( $months )
    {
        if( ! isset( $_GET[ 'post_type' ] ) || 'nf_subs' != $_GET[ 'post_type' ] ) return $months;

        // Returning an empty array should hide the dropdown.
        return array();
    }

    /**
     * Add Filters
     *
     * @return bool
     */
    public function add_filters()
    {
        global $typenow;

        // Bail if we aren't in our submission custom post type.
        if ( $typenow != 'nf_subs' ) return false;

        $forms = Ninja_Forms()->form()->get_forms();

        $form_options = array();
        foreach( $forms as $form ){
            $form_options[ $form->get_id() ] = $form->get_setting( 'title' );
        }

        if( isset( $_GET[ 'form_id' ] ) ) {
            $form_selected = $_GET[ 'form_id' ];
        } else {
            $form_selected = 0;
        }

        if( isset( $_GET[ 'begin_date' ] ) ) {
            $begin_date = $_GET[ 'begin_date' ];
        } else {
            $begin_date = '';
        }

        if( isset( $_GET[ 'end_date' ] ) ) {
            $end_date = $_GET[ 'end_date' ];
        } else {
            $end_date = '';
        }

        Ninja_Forms::template( 'admin-menu-subs-filter.html.php', compact( 'form_options', 'form_selected', 'begin_date', 'end_date' ) );

        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_style( 'jquery-ui-datepicker', Ninja_Forms::$url .'deprecated/assets/css/jquery-ui-fresh.min.css' );
    }

    public function table_filter( $query )
    {
        global $pagenow;

        if( $pagenow != 'edit.php' || ! is_admin() || ! isset( $query->query['post_type'] ) || 'nf_subs' != $query->query['post_type'] || ! is_main_query() ) return;

        $vars = &$query->query_vars;

        $form_id = ( ! empty( $_GET['form_id'] ) ) ? $_GET['form_id'] : 0;

        $vars = $this->table_filter_by_form( $vars, $form_id );

        $vars = $this->table_filter_by_date( $vars );

        $vars = apply_filters( 'nf_subs_table_qv', $vars, $form_id );
    }

    public function search( $pieces ) {
        global $typenow;
        // filter to select search query
        if ( is_search() && is_admin() && $typenow == 'nf_subs' && isset ( $_GET['s'] ) ) {
            global $wpdb;

            $keywords = explode(' ', get_query_var('s'));
            $query = "";

            foreach ($keywords as $word) {

                $query .= " (mypm1.meta_value  LIKE '%{$word}%') OR ";
            }

            if (!empty($query)) {
                // add to where clause
                $pieces['where'] = str_replace("((({$wpdb->posts}.post_title LIKE '%", "( {$query} (({$wpdb->posts}.post_title LIKE '%", $pieces['where']);

                $pieces['join'] = $pieces['join'] . " INNER JOIN {$wpdb->postmeta} AS mypm1 ON ({$wpdb->posts}.ID = mypm1.post_id)";

            }
        }
        return ($pieces);
    }

    public function remove_bulk_edit( $actions ) {
        unset( $actions['edit'] );
        return $actions;
    }

    /*
     * PRIVATE METHODS
     */

    /**
     * Custom Columns: ID
     *
     * @param $sub
     * @return mixed
     */
    private function custom_columns_id( $sub )
    {
        return $sub->get_id();
    }

    /**
     * Custom Columns: Submission Date
     *
     * @param $sub
     * @return mixed
     */
    private function custom_columns_sub_date( $sub )
    {
        return $sub->get_sub_date();
    }

    /**
     * Custom Columns: Field
     *
     * @param $sub
     * @param $column
     * @return bool
     */
    private function custom_columns_field( $sub, $column )
    {
        if( FALSE === strpos( $column, 'field_' ) ) return FALSE;

        $field_id = str_replace( 'field_', '', $column );

        return $sub->get_field_value( $field_id );
    }

    private function table_filter_by_form( $vars, $form_id )
    {
        if ( ! isset ( $vars['meta_query'] ) ) {
            $vars['meta_query'] = array(
                array(
                    'key' => '_form_id',
                    'value' => $form_id,
                    'compare' => '=',
                ),
            );
        }

        return $vars;
    }

    private function table_filter_by_date( $vars )
    {
        if( empty( $_GET[ 'begin_date' ] ) || empty( $_GET[ 'end_date' ] ) ) return $vars;

        $begin_date = $_GET[ 'begin_date' ];
        $end_date = $_GET[ 'end_date' ];

        if( $begin_date > $end_date ){
            $temp_date = $begin_date;
            $begin_date = $end_date;
            $end_date = $temp_date;
        }

        if ( ! isset ( $vars['date_query'] ) ) {

            $vars['date_query'] = array(
                'after' => $begin_date,
                'before' => $end_date
            );
        }

        return $vars;
    }

}
