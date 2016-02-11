<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Fields_Spam
 */
class NF_Fields_Spam extends NF_Abstracts_Input
{
    protected $_name = 'spam';

    protected $_type = 'spam';

    protected $_section = 'common';

    protected $_templates = 'textbox';

    protected $_settings = array( 'spam_answer' );

    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Anti-Spam', 'ninja-forms' );

        // Rename Label setting to Question
        $this->_settings[ 'label' ][ 'label' ] = __( 'Question', 'ninja-forms' );
        $this->_settings[ 'label_pos' ][ 'label' ] = __( 'Question Position', 'ninja-forms' );

        // Default Required setting to TRUE and hide setting.
        $this->_settings[ 'required' ][ 'value' ] = 1;
        $this->_settings[ 'required' ][ 'group' ] = '';
    }

    /**
     * Validate
     *
     * @param $field
     * @param $data
     * @return array $errors
     */
    public function validate( $field, $data )
    {
        $errors = parent::validate( $field, $data );

        if(
            ( isset( $field[ 'spam_answer' ] ) && isset( $field[ 'value' ] ) )
            && ( $field[ 'spam_answer' ] != $field[ 'value' ] )
        ){
            $errors[] = __( 'Incorrect Answer', 'ninja-forms' );
        }

        return $errors;
    }

    public function get_parent_type()
    {
        return 'spam';
    }

}
