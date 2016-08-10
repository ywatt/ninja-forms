<?php

// TODO: Convert Auto Total Fields
final class NF_Conversion_Calculations implements NF_Conversion
{
    private $form = array();

    public function __construct( $form_data )
    {
        $this->form = $form_data;
    }

    public function run()
    {
        // Extract Calculations from Fields
        foreach( $this->form[ 'fields' ] as $key => $field ){

            if( 'calc' != $field[ 'type' ] ) continue;

            $calculation = array(
                'order' => $key,
                'name'  => $field[ 'key' ],
                'eq'    => ''
            );

            switch( $field[ 'calc_method' ] ){
                case 'eq':
                    $calculation[ 'eq' ] = $field[ 'calc_eq' ];
                    break;
                case 'fields':
                    // TODO: Convert operations.
                    $calculation[ 'eq' ] = 'TODO: Convert operations.';
                    break;
                case 'auto':
                    // TODO: Convert auto-totals.
                    $calculation[ 'eq' ] = 'TODO: Convert auto-totals.';
                    break;
            }

            $this->form[ 'settings' ][ 'calculations' ][] = $calculation;
        }

        // Replace Field IDs with Merge Tags
        if( isset( $this->form[ 'settings' ][ 'calculations' ] ) ) {
            foreach ($this->form['fields'] as $field) {

                $search = 'field_' . $field['id'];
                $replace = '{field:' . $field['key'] . '}';

                foreach ($this->form['settings']['calculations'] as $key => $calculation) {
                    $this->form['settings']['calculations'][ $key ]['eq'] = str_replace($search, $replace, $calculation['eq']);
                }
            }
        }

        // Convert Calc Fields to HTML Fields for displaying Calculations
        foreach( $this->form[ 'fields' ] as $key => $field ){

            if( 'calc' != $field[ 'type' ] ) continue;

            $this->form[ 'fields' ][ $key ][ 'type' ] = 'html';

            if( 'html' == $field[ 'calc_display_type' ] ){
                // TODO: HTML Output fields seem to loose the label.
                $search = '[ninja_forms_calc]';
                $replace = '{calc:' . $field[ 'key' ] . '}';
                $this->form[ 'fields' ][ $key ][ 'default' ] = str_replace( $search, $replace, $field[ 'calc_display_html' ] );
            } else {
                $this->form[ 'fields' ][ $key ][ 'default' ] = '{calc:' . $field[ 'key' ] . '}';
            }
        }

        return $this->form;
    }

}

add_filter( 'ninja_forms_after_upgrade_settings', 'ninja_forms_conversion_calculations' );
function ninja_forms_conversion_calculations( $form_data ){
    $conversion = new NF_Conversion_Calculations( $form_data );
    return $conversion->run();
}
