<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_BaseClasses_Model
{
    public $id = '';

    public $table_name = '';

    public $meta_table_name = '';

    public $columns = array();

    public $settings = array();

    public function __construct( $id )
    {
        global $wpdb;

        $this->id = $id;

        $this->table_name      = $wpdb->prefix . $this->table_name;
        $this->meta_table_name = $wpdb->prefix . $this->meta_table_name;
    }

    /*
     * PUBLIC METHODS
     */

    public function update_setting( $key, $value )
    {
        global $wpdb;

        if( ! $this->id ) return FALSE;

        if( in_array( $key, $this->columns ) ){

            return $wpdb->update(
                $this->table_name,
                array(
                    $key => $value
                ),
                array(
                    'id' => $this->id
                )
            );
        }

        return $wpdb->update(
            $this->meta_table_name,
            array(
                'value' => $value
            ),
            array(
                'parent_id' => $this->id,
                'key' => $key
            )
        );
    }

    public function update_settings( $data )
    {
        global $wpdb;

        if( ! $this->id ) return FALSE;

        // Separate out columns from meta
        $columns = array();

        // Log results for single return
        $results = array();

        foreach( $data as $key => $value ){

            if( in_array( $key, $this->columns ) ){
                $columns[ $key ] = $value;
                unset( $data[ $key ] );
            } else {
                $results[] = $this->update_setting($key, $value);
            }
        }

        $results[] = $wpdb->update(
            $this->table_name,
            $columns,
            array(
                'id' => $this->id
            )
        );

        return in_array( FALSE, $results );
    }

    /*
     * STATIC METHODS
     */

    public static function get( $id )
    {

    }
}
