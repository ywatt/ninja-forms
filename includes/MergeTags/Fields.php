<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_MergeTags_Fields
 */
final class NF_MergeTags_Fields extends NF_Abstracts_MergeTags
{
    protected $id = 'fields';

    public function __construct()
    {
        parent::__construct();
        $this->title = __( 'Fields', 'ninja-forms' );
        $this->merge_tags = Ninja_Forms()->config( 'MergeTagsFields' );
    }

    public function __call($name, $arguments)
    {
        return $this->merge_tags[ $name ][ 'field_value' ];
    }

    public function all_fields()
    {
        $return = '<table>';
        foreach( $this->merge_tags[ 'all_fields' ][ 'fields' ] as $field ){
            $return .= '<tr id="ninja_forms_field_' . $field[ 'id' ] . '"><td>' . $field[ 'label' ] .':</td><td>' . $field[ 'value' ] . '</td></tr>';
        }
        $return .= '</table>';
        return $return;
    }

    public function add_field( $field )
    {
        if( in_array( $field[ 'type' ], array( 'submit' ) ) ) return;

        $callback = 'field_' . $field[ 'id' ];

        $this->merge_tags[ 'all_fields' ][ 'fields' ][ $callback ] = $field;

        $this->merge_tags[ $callback ] = array(
            'id' => $field[ 'id' ],
            'tag' => '{field:' . $field[ 'id' ] . '}',
            'callback' => $callback,
            'field_value' => $field[ 'value' ]
        );

        if( ! isset( $field[ 'key' ] ) ) return;

        $this->merge_tags[ $callback ] = array(
            'id' => $field[ 'key' ],
            'tag' => '{field:' . $field[ 'key' ] . '}',
            'callback' => $callback,
            'field_value' => $field[ 'value' ]
        );
    }

} // END CLASS NF_MergeTags_Fields
