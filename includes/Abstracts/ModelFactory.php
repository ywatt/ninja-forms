<?php if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class NF_Abstracts_ModelFactory
 */
class NF_Abstracts_ModelFactory
{
    /**
     * @var
     */
    protected $_db;

    /**
     * @var object
     */
    protected $_object;

    /**
     * @var array
     */
    protected $_fields = array();

    /**
     * @var array
     */
    protected $_actions = array();

    /**
     * @var array
     */
    protected $_objects = array();

    public function __construct( $db, $id )
    {
        $this->_db = $db;

        $this->_object = new NF_Database_Models_Form( $this->_db, $id );

        return $this;
    }

    /**
     * Returns the parent object set by the constructor for chained methods.
     *
     * @return object
     */
    public function get()
    {
        return $this->_object;
    }

    /*
     * FIELDS
     */

    /**
     * Sets the parent object for chained methods as a Field.
     *
     * @param string $id
     * @return $this
     */
    public function field( $id = '' )
    {
        $form_id = $this->_object->get_id();

        $this->_object = new NF_Database_Models_Field( $this->_db, $id, $form_id );

        return $this;
    }

    /**
     * Returns a field object.
     *
     * @param $id
     * @return NF_Database_Models_Field
     */
    public function get_field( $id )
    {
        $form_id = $this->_object->get_id();

        return $this->_fields[ $id ] = new NF_Database_Models_Field( $this->_db, $id, $form_id );
    }

    /**
     * Returns an array of field objects for the set form (object).
     *
     * @param array $where
     * @param bool|FALSE $fresh
     * @return array
     */
    public function get_fields( $where = array(), $fresh = FALSE)
    {
        if( $where || $fresh || ! $this->_fields ){

            $form_id = $this->_object->get_id();

            $model_shell = new NF_Database_Models_Field( $this->_db, 0 );

            $fields = $model_shell->find( $form_id, $where );

            foreach( $fields as $field ){
                $this->_fields[ $field->get_id() ] = $field;
            }
        }

        return $this->_fields;
    }

    /*
     * ACTIONS
     */

    /**
     * Sets the parent object for chained methods as an Action.
     *
     * @param string $id
     * @return $this
     */
    public function action( $id ='' )
    {
        $form_id = $this->_object->get_id();

        $this->_object = new NF_Database_Models_Action( $this->_db, $id, $form_id );

        return $this;
    }

    /**
     * Returns an action object.
     *
     * @param $id
     * @return NF_Database_Models_Action
     */
    public function get_action( $id )
    {
        $form_id = $this->_object->get_id();

        return $this->_actions[ $id ] = new NF_Database_Models_Action( $this->_db, $id, $form_id );
    }

    /**
     * Returns an array of action objects for the set form (object).
     *
     * @param array $where
     * @param bool|FALSE $fresh
     * @return array
     */
    public function get_actions( $where = array(), $fresh = FALSE)
    {
        if( $where || $fresh || ! $this->_actions ){

            $form_id = $this->_object->get_id();

            $model_shell = new NF_Database_Models_Action( $this->_db, 0 );

            $actions = $model_shell->find( $form_id, $where );

            foreach( $actions as $action ){
                $this->_actions[ $action->get_id() ] = $action;
            }
        }

        return $this->_actions;
    }

    /*
     * OBJECTS
     */

    /**
     * Sets the parent object for chained methods as an Object.
     *
     * @param string $id
     * @return $this
     */
    public function object( $id )
    {
        $form_id = $this->_object->get_id();

        $this->_object = new NF_Database_Models_Object( $this->_db, $id, $form_id );

        return $this;
    }

    /**
     * Returns an object.
     *
     * @param $id
     * @return NF_Database_Models_Object
     */
    public function get_object( $id )
    {
        $parent_id = $this->_object->get_id();

        return $this->_objects[ $id ] = new NF_Database_Models_Object( $this->_db, $id, $parent_id );
    }

    /**
     * Returns an array of objects for the set object.
     *
     * @param array $where
     * @param bool|FALSE $fresh
     * @return array
     */
    public function get_objects( $where = array(), $fresh = FALSE)
    {
        if( $where || $fresh || ! $this->_objects ){

            $form_id = $this->_object->get_id();

            $model_shell = new NF_Database_Models_Object( $this->_db, 0 );

            $objects = $model_shell->find( $form_id, $where );

            foreach( $objects as $object ){
                $this->_objects[ $object->get_id() ] = $object;
            }
        }

        return $this->_objects;
    }

    /*
     * SUBMISSIONS
     */

    public function sub( $id = '' )
    {
        $form_id = $this->_object->get_id();

        $this->_object = new NF_Database_Models_Submission( $this->_db, $id, $form_id );

        return $this;
    }

    public function get_sub( $id )
    {
        $parent_id = $this->_object->get_id();

        return $this->_objects[ $id ] = new NF_Database_Models_Submission( $this->_db, $id, $parent_id );
    }

    public function get_subs( $where = array(), $fresh = FALSE )
    {
        if( $where || $fresh || ! $this->_objects ){

            $form_id = $this->_object->get_id();

            $model_shell = new NF_Database_Models_Submission( $this->_db, 0 );

            $objects = $model_shell->find( $form_id, $where );

            foreach( $objects as $object ){
                $this->_objects[ $object->get_id() ] = $object;
            }
        }

        return $this->_objects;
    }


} // End Class NF_Abstracts_ModelFactory
