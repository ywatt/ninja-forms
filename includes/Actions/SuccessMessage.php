<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Action_SuccessMessage
 */
final class NF_Actions_SuccessMessage extends NF_Abstracts_Action
{
    /**
    * @var string
    */
    protected $_name  = '';

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

    }

    /*
    * PUBLIC METHODS
    */

    public function save()
    {

    }

    public function process( $form_id, $data )
    {
        $data['success_message'] = 'Success Again!';

        return $data;
    }
}
