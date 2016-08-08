<?php

final class NF_Upgrades_Calculations
{
    private $form_settings;

    private $calculations;

    public function __construct()
    {
        // Run conversion after upgrade settings so that field keys are available.
        add_filter( 'ninja_forms_after_upgrade_settings', array( $this, 'upgrade' ) );
    }

    public function upgrade( $form_settings )
    {
        $calculation_fields = array_filter( $form_settings[ 'fields' ], array( $this, 'filter_calculation_fields' ) );
        array_map( array( $this, 'convert_calculations' ), $calculation_fields, array_keys( $calculation_fields ) );
        $form_settings[ 'calculations' ] = $this->calculations;
        return $form_settings;
    }

    private function filter_calculation_fields( $field_settings )
    {
        return ( '_calc' == $field_settings[ 'type' ] );
    }

    private function convert_calculations( $calculation_field, $key )
    {
        switch ( $calculation_field[ 'calc_method' ] ) {
            case 'auto':
                break;
            case 'fields':
                break;
            case 'eq':
                break;
        }

        $this->calculations[] = array(
            'order' => $key,
            'name'  => $calculation_field[ 'label' ],
            'eq'    => ''
        );
    }

}