<?php if ( ! defined( 'ABSPATH' ) ) exit;

final class NF_MergeTags
{
    private $replace_values = array(
        'user:firstname' => 'user_firstname',
        'user:lastname' => 'user_lastname',
        'user:email' => 'user_email',
        'system:date' => 'system_date',
        'system:ip' => 'system_ip'
    );

    public function __construct()
    {
        add_filter( 'ninja_forms_render_default_value', array( $this, 'replace' ) );
    }

    public function replace( $default_value )
    {
        foreach( $this->replace_values as $key => $value ){

            $find = "{" . $key . "}";

            if( FALSE !== strpos( $default_value, $key ) ){

                $replace = ( method_exists( $this, $value ) ) ? $this->$value() : $value;

                $default_value = str_replace( $find, $replace, $default_value );
            }
        }

        return $default_value;
    }

    private function user_firstname()
    {
        $current_user = wp_get_current_user();

        return ( $current_user ) ? $current_user->user_firstname : '';
    }

    private function user_lastname()
    {
        $current_user = wp_get_current_user();

        return ( $current_user ) ? $current_user->user_lastname : '';
    }

    private function user_email()
    {
        $current_user = wp_get_current_user();

        return ( $current_user ) ? $current_user->user_email : '';
    }

    private function system_date()
    {
        return date( 'm/d/Y', time() );
    }

    private function system_ip()
    {
        $ip = '127.0.0.1';
        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return apply_filters( 'nf_get_ip', $ip );
    }
}