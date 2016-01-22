<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_Email
 */
final class NF_Actions_Email extends NF_Abstracts_Action
{
    /**
    * @var string
    */
    protected $_name  = 'email';

    /**
    * @var array
    */
    protected $_tags = array();

    /**
    * @var string
    */
    protected $_timing = 'normal';

    /**
    * @var int
    */
    protected $_priority = '10';

    /**
    * Constructor
    */
    public function __construct()
    {
        parent::__construct();

        $this->_nicename = __( 'Email', 'ninja-forms' );

        $settings = Ninja_Forms::config( 'ActionEmailSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    /*
    * PUBLIC METHODS
    */

    public function process( $action_settings, $form_id, $data )
    {
        $attachments = array();

        $headers = $this->_format_headers( $action_settings );

        wp_mail(
            $action_settings['to'],
            $action_settings['subject'],
            $action_settings['message'],
            $headers,
            $attachments
        );

        $data[ 'actions' ][ 'email' ][ 'headers' ] = $headers;

        return $data;
    }

    private function _format_headers( $settings )
    {
        $headers = array();

        $headers[] = 'Content-Type: text/' . $settings[ 'format' ];
        $headers[] = 'charset=UTF-8';

        $headers[] = $this->_format_from( $settings );

        $headers = array_merge( $headers, $this->_format_recipients( $settings ) );

        return $headers;
    }

    private function _format_from( $settings )
    {
        $from_name = get_bloginfo( 'name', 'raw' );
        $from_name = apply_filters( 'ninja_forms_action_email_from_name', $from_name );
        $from_name = ( $settings[ 'from_name' ] ) ? $settings[ 'from_name' ] : $from_name;

        $from_address = get_bloginfo( 'admin_email' );
        $from_address = apply_filters( 'ninja_forms_action_email_from_address', $from_address );
        $from_address = ( $settings[ 'from_address' ] ) ? $settings[ 'from_address' ] : $from_address;

        return $this->_format_recipient( 'from', $from_address, $from_name );
    }

    private function _format_recipients( $settings )
    {
        $headers = array();

        $recipient_settings = array(
            'Cc' => $settings[ 'cc' ],
            'Bcc' => $settings[ 'bcc' ],
            'Reply-to' => $settings[ 'reply-to' ],
        );

        foreach( $recipient_settings as $type => $emails ){

            $emails = explode( ',', $emails );

            foreach( $emails as $email ) {
                $headers[] = $this->_format_recipient($type, $email);
            }
        }

        return $headers;
    }

    private function _format_recipient( $type, $email, $name = '' )
    {
        $type = ucfirst( $type );

        if( ! $name ) $name = $email;

        $recipient = "$type: $name <$email>";

        return $recipient;
    }

    private function _create_csv( $fields )
    {

    }
}
