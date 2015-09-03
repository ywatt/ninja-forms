<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_UserInfo
 */
abstract class NF_Abstracts_UserInfo extends NF_Abstracts_Input
{
    protected $_name = 'input';

    protected $_group = 'standard_fields';

    protected $_type = 'text';

    public function __construct()
    {
        parent::__construct();

        $settings = Ninja_Forms::config( 'UserInfoSettings' );

        $this->_settings = array_merge( $this->_settings, $settings );
    }

    public function template()
    {
        // Placeholder output
        ?>
        <input type="<?php echo $this->_type; ?>">
        <?php
    }

    public function validate( $value )
    {
        parent::validate( $value );
    }

}
