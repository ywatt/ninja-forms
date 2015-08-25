<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_Abstracts_Model
{
    /**
     * @var int
     */
    protected $_id = '';

    /**
     * @var string
     */
    protected $_db = '';

    /**
     * @var string
     */
    protected $_table_name = '';

    /**
     * @var string
     */
    protected $_meta_table_name = '';

    /**
     * @var string
     */
    protected $_relationships_table = 'nf_relationships';

    /**
     * @var array
     */
    protected $_columns = array();

    /**
     * @var array
     */
    protected $_settings = array();

    /**
     * @var bool
     */
    protected $_cache = TRUE;

    /**
     * Constructor
     *
     * @param $id
     */
    public function __construct( $id )
    {
        global $wpdb;

        $this->_db = $wpdb;

        $this->_id = $id;

        $this->_table_name          = $wpdb->prefix . $this->_table_name;
        $this->_meta_table_name     = $wpdb->prefix . $this->_meta_table_name;
        $this->_relationships_table = $wpdb->prefix . $this->_relationships_table;

        $this->_settings = $this->cache( FALSE )->get_settings();
    }

    /*
     * PUBLIC METHODS
     */

    /**
     * Get Settings
     *
     * @param string ...$only returns a subset of the object's settings
     * @return array
     */
    public function get_settings()
    {
        $only = func_get_args();

        if( ! $this->_cache ) {

            $sql = "SELECT `key`, `value` FROM `$this->_meta_table_name` WHERE `parent_id` = $this->_id";

            if ($only && is_array($only) && (count($only) == count($only, COUNT_RECURSIVE))) {
                $sql .= ' AND (`key` = "' . implode('" OR `key` = "', $only) . '")';
            }

            $results = $this->_db->get_results($sql);

            foreach ($results as $meta) {
                $this->_settings[$meta->key] = $meta->value;
            }
        }

        return ( $only && is_array( $only ) ) ? array_intersect_key( $this->_settings, array_flip( $only ) ) : $this->_settings;
    }

    /**
     * Update Setting
     *
     * @param $key
     * @param $value
     * @return bool|false|int
     */
    public function update_setting( $key, $value )
    {
        if( ! $this->_id ) return FALSE;

        if( in_array( $key, $this->_columns ) ){

            return $this->_db->update(
                $this->_table_name,
                array(
                    $key => $value
                ),
                array(
                    'id' => $this->_id
                )
            );
        }

        return $this->_db->update(
            $this->_meta_table_name,
            array(
                'value' => $value
            ),
            array(
                'parent_id' => $this->_id,
                'key' => $key
            )
        );
    }

    /**
     * Update Settings
     *
     * @param $data
     * @return bool
     */
    public function update_settings( $data )
    {
        if( ! $this->_id ) return FALSE;

        // Separate out columns from meta
        $columns = array();

        // Log results for single return
        $results = array();

        foreach( $data as $key => $value ){

            if( in_array( $key, $this->_columns ) ){
                $columns[ $key ] = $value;
                unset( $data[ $key ] );
            } else {
                $results[] = $this->update_setting($key, $value);
            }
        }

        $results[] = $this->_db->update(
            $this->_table_name,
            $columns,
            array(
                'id' => $this->_id
            )
        );

        return in_array( FALSE, $results );
    }

    /**
     * Delete
     *
     * @return bool
     */
    public function delete()
    {
        $results = array();

        $results[] = $this->_db->delete(
            $this->_table_name,
            array(
                'id' => $this->_id
            )
        );

        $results[] = $this->_db->delete(
            $this->_meta_table_name,
            array(
                'parent_id' => $this->_id
            )
        );

        // TODO: Cascade through Object Relationships

        return in_array( FALSE, $results );
    }

    /**
     * Find
     *
     * @param string $where
     * @return array|bool
     */
    public function find( $where = '' )
    {
        if( ! $where || ! is_array( $where ) ) return FALSE;

        $where_statement = '';
        foreach( $where as $key => $value ){
            $where_statement[] = $key . ' = ' . $value;
        }

        $where_statement = implode( ' AND ', $where_statement );

        $ids = $this->_db->get_col(
            "
            SELECT id
            FROM   $this->_table_name
            WHERE  $where_statement
            "
        );

        $class = get_class( $this );

        $results = array();
        foreach( $ids as $id ){
            $results[] = new $class( $id );
        }

        return $results;
    }

    /**
     * Cache Flag
     * 
     * @param string $cache
     * @return $this
     */
    public function cache( $cache = '' )
    {
        if( $cache !== '' ) {
            $this->_cache = $cache;
        }

        return $this;
    }

}
