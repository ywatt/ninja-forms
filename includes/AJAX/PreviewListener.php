<?php

final class NF_AJAX_PreviewListener implements JsonStreamingParser_Listener
{
    /*
    |--------------------------------------------------------------------------
    | Document Callbacks
    |--------------------------------------------------------------------------
    */
    public function start_document()
    {
        // This section intentionally left blank.
    }
    public function end_document()
    {
        // This section intentionally left blank.
    }

    /*
    |--------------------------------------------------------------------------
    | Object Callbacks
    |--------------------------------------------------------------------------
    */
    public function start_object()
    {
        // This section intentionally left blank.
    }
    public function end_object()
    {
        // This section intentionally left blank.
    }

    /*
    |--------------------------------------------------------------------------
    | Array Callbacks
    |--------------------------------------------------------------------------
    */
    public function start_array()
    {
        // This section intentionally left blank.
    }
    public function end_array()
    {
        // This section intentionally left blank.
    }

    /*
    |--------------------------------------------------------------------------
    | Key Callback
    |--------------------------------------------------------------------------
    | Key will always be a string
    */
    public function key($key)
    {
        // This section intentionally left blank.
    }

    /*
    |--------------------------------------------------------------------------
    | Value Callback
    |--------------------------------------------------------------------------
    | Note that value may be a string, integer, boolean, etc.
    */
    public function value( $value )
    {
        // This section intentionally left blank.
    }

    /*
    |--------------------------------------------------------------------------
    | Whitespace Callback
    |--------------------------------------------------------------------------
    */
    public function whitespace( $whitespace )
    {

    }
}
