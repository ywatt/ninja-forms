<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class WPN_Helper
 *
 * The WP Ninjas Static Helper Class
 *
 * Provides additional helper functionality to WordPress helper functions.
 */
final class WPN_Helper
{
    /**
     * @param $value
     * @return array|string
     */
    public static function addslashes( $value )
    {
        $value = is_array($value) ?
            array_map(array( 'self', 'addslashes' ), $value) :
            addslashes($value);
        return $value;
    }

    /**
     * @param $input
     * @return array|string
     */
    public static function utf8_encode( $input ){
        if ( is_array( $input ) )    {
            return array_map( array( 'self', 'utf8_encode' ), $input );
        }else{
            return utf8_encode( $input );
        }
    }

    /**
     * @param $search
     * @param $replace
     * @param $subject
     * @return mixed
     */
    public static function str_replace( $search, $replace, $subject ){
        if( is_array( $subject ) ){
            foreach( $subject as &$oneSubject )
                $oneSubject = WPN_Helper::str_replace($search, $replace, $oneSubject);
            unset($oneSubject);
            return $subject;
        } else {
            return str_replace($search, $replace, $subject);
        }
    }

    /**
     * @param $value
     * @param int $flag
     * @return array|string
     */
    public static function html_entity_decode( $value, $flag = ENT_COMPAT ){
        $value = is_array($value) ?
            array_map( array( 'self', 'html_entity_decode' ), $value) :
            html_entity_decode( $value, $flag );
        return $value;
    }

    /**
     * @param $value
     * @return array|string
     */
    public static function htmlspecialchars( $value ){
        $value = is_array($value) ?
            array_map( array( 'self', 'htmlspecialchars' ), $value) :
            htmlspecialchars( $value );
        return $value;
    }

    /**
     * @param $value
     * @return array|string
     */
    public static function stripslashes( $value ){
        $value = is_array($value) ?
            array_map( array( 'self', 'stripslashes' ), $value) :
            stripslashes($value);
        return $value;
    }

    /**
     * @param $value
     * @return array|string
     */
    public static function esc_html( $value )
    {
        $value = is_array($value) ?
            array_map( array( 'self', 'esc_html' ), $value) :
            esc_html($value);
        return $value;
    }

    /**
     * @param $value
     * @return array|string
     */
    public static function kses_post( $value )
    {
        $value = is_array( $value ) ?
            array_map(  array( 'self', 'kses_post' ), $value ) :
            wp_kses_post($value);
        return $value;
    }

    /**
     * @param $value
     * @return array|string
     */
    public static function strip_tags( $value )
    {
        $value = is_array( $value ) ?
            array_map( array( 'self', 'strip_tags' ), $value ) :
            strip_tags( $value );
        return $value;
    }

} // End Class WPN_Helper
