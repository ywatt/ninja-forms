<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_logger
 *
 * Handles custom logging for Ninja Forms and Ninja Forms Extensions.
 *
 * PSR-3 and WordPress Compliant where applicable.
 */
final class NF_Abstracts_logger
{
    public static function log( $level, $message, array $context = array() )
    {
        $log = Ninja_Forms()->form()->object();
    }
}
