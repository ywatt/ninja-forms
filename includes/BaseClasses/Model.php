<?php if ( ! defined( 'ABSPATH' ) ) exit;

abstract class NF_BaseClasses_Model
{
    public $table_name = '';

    public $meta_table_name = '';

    public $settings = array();

    public function __construct( $id )
    {
        $this->id = $id;
    }

    public function update_setting( $key, $value )
    {
        global $wpdb;

        if( ! $this->id ) return FALSE;

        return $wpdb->update(
            $this->meta_table_name,
            array(
                $key => $value
            ),
            array(
                'ID' => $this->id
            )
        );
    }

    public function update_settings( $data )
    {
        global $wpdb;

        if( ! $this->id ) return FALSE;

        return $wpdb->update(
            $this->meta_table_name,
            $data,
            array(
                'ID' => $this->id
            )
        );
    }

    public static function get( $id )
    {

    }
}
