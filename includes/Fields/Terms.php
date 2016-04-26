<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Terms
 */
class NF_Fields_Terms extends NF_Fields_ListCheckbox
{
    protected $_name = 'terms';
    protected $_type = 'terms';

    protected $_nicename = 'Terms List';

    protected $_section = '';

    protected $_icon = 'tags';

    protected $_settings = array( 'taxonomy' );

    protected $_settings_exclude = array( 'required' );

    protected $_excluded_taxonomies = array(
        'post_format'
    );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Terms List', 'ninja-forms' );

        add_filter( 'ninja_forms_localize_field_' . $this->_type, array( $this, 'add_term_options' ) );
        add_filter( 'ninja_forms_localize_field_' . $this->_type . '_preview', array( $this, 'add_term_options' ) );

        $term_settings = array();
        $taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
        foreach( $taxonomies as $name => $taxonomy ){

            if( in_array( $name, $this->_excluded_taxonomies ) ) continue;

            $this->_settings[ 'taxonomy' ][ 'options' ][] = array(
                'label' => $taxonomy->labels->name,
                'value' => $name
            );

            $terms = get_terms( $name, array( 'hide_empty' => false ) );

            if( ! $terms ){
                $term_settings[] =  array(
                    'name' => $name . '_no_terms',
                    'type' => 'html',
                    'width' => 'full',
                    'value' => sprintf( __( 'No available terms for this taxonomy. %sAdd a term%s', 'ninja-forms' ), '<a href="' . admin_url( "edit-tags.php?taxonomy=$name" ) . '">', '</a>' ),
                    'deps' => array(
                        'taxonomy' => $name
                    )
                );
            }

            foreach( $terms as $term ){

                if( 1 == $term->term_id ) continue;

                $term_settings[] =  array(
                    'name' => 'taxonomy_term_' . $term->term_id,
                    'type' => 'toggle',
                    'label' => $term->name . ' (' . $term->count .')',
                    'width' => 'one-third',
                    'deps' => array(
                        'taxonomy' => $name
                    )
                );
            }
        }

        $this->_settings[ 'taxonomy_terms' ] = array(
            'name' => 'taxonomy_terms',
            'type' => 'fieldset',
            'label' => __( 'Available Terms' ),
            'width' => 'full',
            'group' => 'primary',
            'settings' => $term_settings
        );

        $this->_settings[ 'options' ][ 'group' ] = '';
    }

    public function add_term_options( $field )
    {
        if( ! isset( $field[ 'settings' ][ 'taxonomy' ] ) ) return $field;

        $terms = get_terms( $field[ 'settings' ][ 'taxonomy' ], array( 'hide_empty' => false ) );

        $field['settings']['options'] = array();
        foreach( $terms as $term ) {

            if( ! isset( $field[ 'settings' ][ 'taxonomy_term_' . $term->term_id ] ) ) continue;
            if( ! $field[ 'settings' ][ 'taxonomy_term_' . $term->term_id ] ) continue;

            $field['settings']['options'][] = array(
                'label' => $term->name,
                'value' => $term->term_id,
                'calc' => '',
                'selected' => 0,
                'order' => 0
            );
        }

        return $field;
    }
}
