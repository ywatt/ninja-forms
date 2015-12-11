<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Product
 */
class NF_Fields_Product extends NF_Abstracts_Input
{
    protected $_name = 'product';

    protected $_section = 'pricing';

    protected $_aliases = array();

    protected $_type = 'textbox';

    protected $_templates = array( 'product', 'textbox', 'hidden', 'listselect' );

    protected $_test_value = 'Lorem ipsum';

    protected $processing_fields = array( 'quantity', 'modifier', 'shipping', 'tax', 'total' );

    public function __construct()
    {
        parent::__construct();

        $this->_settings = $this->load_settings(
            array( 'label', 'label_pos', 'product_use_quantity', 'product_price', 'product_type', 'product_type', 'classes' )
        );

        $this->_nicename = __( 'Product', 'ninja-forms' );
    }

    public function process( $product, $data )
    {
        $related = array();

        foreach( $data[ 'fields' ] as $key => $field ){

            if( ! in_array( $field[ 'type' ], $this->processing_fields ) ) continue;

            $type = $field[ 'type' ];

            if( ! isset( $field[ 'product_assignment' ] ) ) continue;
            
            if( $product[ 'id' ] != $field[ 'product_assignment' ] ) continue;
            
            $related[ $type ] = &$data[ 'fields' ][ $key ]; // Assign by reference
        }

        $total = floatval( $product[ 'product_price' ] );

        echo "<pre>";
        var_dump($total);
        echo "</pre>";

        if( isset( $related[ 'quantity' ] ) ){
            $total = $total * $related[ 'quantity' ][ 'value' ];
        }

        echo "<pre>";
        var_dump($total);
        echo "</pre>";

        if( isset( $related[ 'modifier' ] ) ){
            //TODO: Handle multiple modifiers.
        }

        if( isset( $related[ 'tax' ] ) ){
            $total = $total * ( 1 + ( ($related[ 'tax' ][ 'tax_rate' ] / 100 ) ) );
        }

        echo "<pre>";
        var_dump($total);
        echo "</pre>";

        if( isset( $related[ 'shipping' ] ) ){
            $total += $related[ 'shipping' ][ 'shipping_cost' ];
        }

        echo "<pre>";
        var_dump($total);
        echo "</pre>";

        if( isset( $related[ 'total' ] ) ){
            $related[ 'total' ][ 'value' ] = $data[ 'total' ] = number_format( $total, 2 );
        }

        echo "<pre>";
        var_dump($total);
        echo "</pre>";

        die();

        return $data;
    }
}
