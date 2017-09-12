<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_Admin_Menus_Addons extends NF_Abstracts_Submenu
{
    public $parent_slug = 'ninja-forms';

    public $menu_slug = 'ninja-forms#apps';

    public $priority = 13;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_page_title()
    {
        return __( 'Add-Ons', 'ninja-forms' );
    }

    public function get_capability()
    {
        return apply_filters( 'ninja_forms_admin_extend_capabilities', $this->capability );
    }

    public function display()
    {
        $feed = file_get_contents( Ninja_Forms::$dir . '/includes/addons.json' );
        $feed = json_decode( $feed, true );
        $items = $feed[ 'addons' ];

        $notices = array();

        foreach ($items as $key => $item) {
            $plugin_data = array();
            if( !empty( $item['plugin'] ) && file_exists( WP_PLUGIN_DIR.'/'.$item['plugin'] ) ){
                $items[ $key ][ 'installed' ] = true;
                $plugin_data = get_plugin_data( WP_PLUGIN_DIR.'/'.$item['plugin'], false, true );
            }

            $version = isset ( $plugin_data['Version'] ) ? $plugin_data['Version'] : '';

            if ( ! empty ( $version ) && $version < $item['version'] ) {

                $notices[] = array(
                    'title' => $item[ 'title' ],
                    'old_version' => $version,
                    'new_version' => $item[ 'version' ]
                );
            }
            unset( $item ); // Unset to avoid conflict with variable name in later loop.
        }

        $groups = $feed[ 'categories' ];
        foreach( $items as $item ){
            if( ! isset( $item[ 'category' ] ) ) continue;

            foreach( (array) $item[ 'category' ] as $group ) {
                if( ! isset( $groups[ $group ][ 'addons' ] ) ) $groups[ $group ][ 'addons' ] = array();
                $groups[ $group ][ 'addons' ][] = $item;

                if( in_array( $group, array( 'crm', 'email' ) )
                    && isset( $item[ 'installed' ] ) && $item[ 'installed' ] ){
                    $groups[ $group ][ 'priority' ] = 0;
                }
            }

        }

        foreach( $groups as &$group ){
            if( ! isset( $group[ 'addons' ] ) ) {
                unset( $groups[ $group ] );
                continue;
            }
            usort( $group[ 'addons' ], array( $this, 'sort_addons_by_installed' ) );
        }

        usort( $groups, array( $this, 'sort_groups_by_priority' ) );


        Ninja_Forms::template( 'admin-menu-addons.html.php', compact( 'groups', 'notices' ) );
    }

    public function sort_addons_by_installed( $a, $b )
    {
        if( isset( $a[ 'installed' ] ) && $a[ 'installed' ]
            && isset( $b[ 'installed' ] ) && $b[ 'installed' ] ){
            return 0;
        }
        if( isset( $a[ 'installed' ] ) && $a[ 'installed' ] ){
            return 1;
        }
        return -1;
    }

    public function sort_groups_by_priority( $a, $b )
    {
        return $b[ 'priority' ] - $a[ 'priority' ];
    }

} // End Class NF_Admin_Addons
