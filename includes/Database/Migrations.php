<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Database_Migrations
{
    protected $migrations = array();

    public function __construct()
    {
        $this->migrations[ 'forms' ]         = new NF_Database_Migrations_Forms();
        $this->migrations[ 'form_meta' ]     = new NF_Database_Migrations_FormMeta();
        $this->migrations[ 'fields' ]        = new NF_Database_Migrations_Fields();
        $this->migrations[ 'field_meta' ]    = new NF_Database_Migrations_FieldMeta();
        $this->migrations[ 'actions' ]       = new NF_Database_Migrations_Actions();
        $this->migrations[ 'action_meta' ]   = new NF_Database_Migrations_ActionMeta();
        $this->migrations[ 'objects' ]       = new NF_Database_Migrations_Objects();
        $this->migrations[ 'object_meta' ]   = new NF_Database_Migrations_ObjectMeta();
        $this->migrations[ 'relationships' ] = new NF_Database_Migrations_Relationships();
        $this->migrations[ 'settings' ]      = new NF_Database_Migrations_Settings();
    }

    public function migrate()
    {
        foreach( $this->migrations as $migration ){
            $migration->_run();
        }
    }

    public function nuke( $areYouSure = FALSE, $areYouReallySure = FALSE )
    {
        if( ! $areYouSure || ! $areYouReallySure ) return;

        global $wpdb;

        foreach( $this->migrations as $migration ){

            if( ! $migration->table_name ) continue;

            if( 0 == $wpdb->query( "SHOW TABLES LIKE '" . $migration->table_name . "'" ) ) continue;

            $wpdb->query( "DROP TABLE $migration->table_name" );

        }

        /* Drop Deprecated Tables (v2.9.x) */
        $wpdb->query( "DROP TABLE '{$wpdb->prefix}nf_objectmeta'" );
        $wpdb->query( "DROP TABLE '{$wpdb->prefix}nf_objects'" );
        $wpdb->query( "DROP TABLE '{$wpdb->prefix}nf_relationships'" );
        $wpdb->query( "DROP TABLE '{$wpdb->prefix}ninja_forms_fav_fields'" );
        $wpdb->query( "DROP TABLE '{$wpdb->prefix}ninja_forms_fields'" );

        delete_option( 'ninja_forms_settings' );
        delete_option( 'ninja_forms_load_deprecated' );
        delete_option( 'ninja_forms_allow_tracking' );
        delete_option( 'ninja_forms_do_not_allow_tracking' );
    }

}