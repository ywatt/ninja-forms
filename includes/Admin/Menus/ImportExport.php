<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_ImportExport extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $page_title = 'Import / Export';

    public function __construct()
    {
        parent::__construct();
    }

    public function display()
    {
        $tabs = apply_filters( 'nf-import-export-tabs', array(
            'forms' => __( 'Form', 'ninja-forms' ),
            'favorite_fields' => __( 'Favorite Fields', 'ninja-forms' )
            )
        );

        $active_tab = ( isset( $_GET[ 'tab' ] ) ) ? $_GET[ 'tab' ] : reset( array_keys( $tabs ) );

        $this->add_meta_boxes();

        wp_enqueue_script('postbox');
        wp_enqueue_script('jquery-ui-draggable');

        wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
        wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );

        Ninja_Forms::template( 'admin-menu-import-export.html.php', compact( 'tabs', 'active_tab' ) );
    }

    public function add_meta_boxes()
    {
        /*
         * Forms
         */
        add_meta_box(
            'nf_import_export_forms_import',
            __( 'Import Forms', 'ninja-forms' ),
            function(){
                Ninja_Forms::template( 'admin-metabox-import-export-forms-import.html.php' );
            },
            'nf_import_export_forms'
        );

        add_meta_box(
            'nf_import_export_forms_export',
            __( 'Export Forms', 'ninja-forms' ),
            function(){
                Ninja_Forms::template( 'admin-metabox-import-export-forms-export.html.php' );
            },
            'nf_import_export_forms'
        );

        /*
         * FAVORITE FIELDS
         */
        add_meta_box(
            'nf_import_export_favorite_fields_import',
            __( 'Import Favorite Fields', 'ninja-forms' ),
            function(){
                Ninja_Forms::template( 'admin-metabox-import-export-favorite-fields-import.html.php' );
            },
            'nf_import_export_favorite_fields'
        );

        add_meta_box(
            'nf_import_export_favorite_fields_export',
            __( 'Export Facvorite Fields', 'ninja-forms' ),
            function(){
                Ninja_Forms::template( 'admin-metabox-import-export-favorite-fields-export.html.php' );
            },
            'nf_import_export_favorite_fields'
        );
    }
}
