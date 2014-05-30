<?php
/**
 * Wrangles our admin REST API.
 *
 * @package     Ninja Forms
 * @subpackage  Classes/Admin
 * @copyright   Copyright (c) 2014, WPNINJAS
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       3.0
*/

class NF_Admin_Rest_API {
    /**
     * Property: method
     * The HTTP method this request was made in, either GET, POST, PUT or DELETE
     */
    protected $method = '';
    /**
     * Property: endpoint
     * The Model requested in the URI. eg: /files
     */
    protected $endpoint = '';
    /**
     * Property: file
     * Stores the input of the PUT request
     */
     protected $file = Null;

    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */

    public function __construct() {
         // Bail if we aren't in the admin.
        if ( ! is_admin() )
            return false;

        global $pagenow;

        if ( $pagenow == 'admin.php' and isset ( $_REQUEST['page'] ) and $_REQUEST['page'] == 'ninja-forms' and isset ( $_REQUEST['nf_rest'] ) and $_REQUEST['nf_rest'] != '' ) {
            add_action( 'admin_init', array( $this, 'check_rest_api' ), 11 );
        }
    }

    public function check_rest_api() {
        $capabilities = 'manage_options';
        $capabilities = apply_filters( 'ninja_forms_admin_menu_capabilities', $capabilities );
        if ( current_user_can( $capabilities ) ) {
            // Requests from the same server don't have a HTTP_ORIGIN header
            if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
                $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
            }

            $request = $_REQUEST['nf_rest'];

            try {
                $this->initiate_api_request($request, $_SERVER['HTTP_ORIGIN']);
                echo $this->processAPI();
            } catch (Exception $e) {
                echo json_encode(Array('error' => $e->getMessage()));
            }
            die();  
        }
    }

    public function initiate_api_request($request) {
        //header("Access-Control-Allow-Orgin: *");
        //header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->args = explode('/', rtrim($request, '/'));
        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

        switch($this->method) {
        case 'DELETE':
        case 'POST':
        	$this->file = file_get_contents("php://input");
            $this->request = $this->_cleanInputs($_POST);
            break;
        case 'GET':
            $this->request = $this->_cleanInputs($_GET);
            break;
        case 'PUT':
            $this->request = $this->_cleanInputs($_GET);
            $this->file = file_get_contents("php://input");
            break;
        default:
            $this->_response('Invalid Method', 405);
            break;
        }
    }

    public function processAPI() {
        if ((int)method_exists($this, $this->endpoint) > 0) {
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response('', 400);
    }

    private function _response($data, $status = 200) {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }

    private function _cleanInputs($data) {
        $clean_input = array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanInputs($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        return $clean_input;
    }

    private function _requestStatus($code) {
        $status = array( 
            100 => 'Continue',   
            101 => 'Switching Protocols',   
            200 => 'OK', 
            201 => 'Created',   
            202 => 'Accepted',   
            203 => 'Non-Authoritative Information',   
            204 => 'No Content',   
            205 => 'Reset Content',   
            206 => 'Partial Content',   
            300 => 'Multiple Choices',   
            301 => 'Moved Permanently',   
            302 => 'Found',   
            303 => 'See Other',   
            304 => 'Not Modified',   
            305 => 'Use Proxy',   
            306 => '(Unused)',   
            307 => 'Temporary Redirect',   
            400 => 'Bad Request',   
            401 => 'Unauthorized',   
            402 => 'Payment Required',   
            403 => 'Forbidden',   
            404 => 'Not Found',   
            405 => 'Method Not Allowed',   
            406 => 'Not Acceptable',   
            407 => 'Proxy Authentication Required',   
            408 => 'Request Timeout',   
            409 => 'Conflict',   
            410 => 'Gone',   
            411 => 'Length Required',   
            412 => 'Precondition Failed',   
            413 => 'Request Entity Too Large',   
            414 => 'Request-URI Too Long',   
            415 => 'Unsupported Media Type',   
            416 => 'Requested Range Not Satisfiable',   
            417 => 'Expectation Failed',   
            500 => 'Internal Server Error',   
            501 => 'Not Implemented',   
            502 => 'Bad Gateway',   
            503 => 'Service Unavailable',   
            504 => 'Gateway Timeout',   
            505 => 'HTTP Version Not Supported'); 
        return ($status[$code])?$status[$code]:$status[500]; 
    }

    private function sortByOrder($a, $b) {
        return $a['order'] - $b['order'];
    }

    protected function rest_api() {
        
        switch( $this->method ) {
            case 'GET':
                $object_id = $this->request['object_id'];
                $object_type = $this->request['object_type'];
                switch( $object_type ) {
                    case 'field_list':
                        $args = array();
                        $fields = nf_get_fields_by_form_id( $object_id, false );
                        foreach ( $fields as $field_id ) {
                            $tmp_array = array();
                            $type = nf_get_field_type( $field_id );
                            $order = nf_get_field_order( $field_id );
                            $label = nf_get_field_setting( $field_id, 'label' );
                            $tmp_array[ 'id' ] = $field_id;
                            $tmp_array[ 'type' ] = $type;
                            $tmp_array[ 'order' ] = $order;
                            $tmp_array[ 'label' ] = $label;
                            $args[] = $tmp_array;
                        }
                        usort( $args, array( $this, 'sortByOrder' ) );
                        return $args;

                }          
                
            case 'PUT':
               
                break;
            case 'DELETE':
                return nf_delete_object( $this->args[0] );
            case 'POST':
                $data = json_decode( $this->file, true );
                if ( isset ( $data['order'] ) ) {
                    foreach ( $data['order'] as $order => $field ) {
                        $field_id = str_replace( 'nf_field_', '', $field );
                        nf_update_field_setting( $field_id, 'order', $order );
                    }
                    return $data['order'];
                }
        }
    }

}