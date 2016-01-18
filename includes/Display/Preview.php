<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Display_Preview
 */
final class NF_Display_Preview
{
    protected $form_id = '';

    public function __construct()
    {
        if ( ! isset( $_GET['nf_preview_form'] ) ) return;

        $this->_form_id = $_GET['nf_preview_form'];

        add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );

        add_filter('the_title', array( $this, 'the_title' ) );
        add_filter('the_content', array( $this, 'the_content' ), 9001 );
        add_filter('get_the_excerpt', array( $this, 'the_content' ) );
        add_filter('template_include', array( $this, 'template_include' ) );
    }

    public function pre_get_posts( $query )
    {
        $query->set( 'posts_per_page', 1 );
    }

    /**
     * @return string
     */
    function the_title()
    {
        $form_title = Ninja_Forms()->form( $this->_form_id )->get()->get_setting( 'title' );

        return "{$form_title} Preview";
    }

    /**
     * @return string
     */
    function the_content()
    {
        return do_shortcode( "[nf_tmp_preview id='{$this->_form_id}']" );
    }

    /**
     * @return string
     */
    function template_include()
    {
        return locate_template( array( 'page.php', 'single.php', 'index.php' ) );
    }

} // END CLASS NF_Display_Preview
