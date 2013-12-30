<?php

function ninja_forms_admin_rest() {
	global $pagenow;

	$capabilities = 'manage_options';
	$capabilities = apply_filters( 'ninja_forms_admin_menu_capabilities', $capabilities );
	if ( current_user_can( $capabilities ) ) {
		if ( $pagenow == 'admin.php' and isset ( $_REQUEST['page'] ) and $_REQUEST['page'] == 'ninja-forms' and isset ( $_REQUEST['rest'] ) and $_REQUEST['rest'] != '' ) {
			// Requests from the same server don't have a HTTP_ORIGIN header
			if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
			    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
			}

			$request = $_REQUEST['rest'];

			try {
			    $Ninja_Forms_Admin_Rest_API = new Form_Settings_API($request, $_SERVER['HTTP_ORIGIN']);
			    echo $Ninja_Forms_Admin_Rest_API->processAPI();
			} catch (Exception $e) {
			    echo json_encode(Array('error' => $e->getMessage()));
			}
			die();	
		}
	}
}

add_action( 'admin_init', 'ninja_forms_admin_rest', 11 );

abstract class Ninja_Forms_Admin_Rest_API
{
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
     * Property: verb
     * An optional additional descriptor about the endpoint, used for things that can
     * not be handled by the basic methods. eg: /files/process
     */
    protected $verb = '';
    /**
     * Property: args
     * Any additional URI components after the endpoint and verb have been removed, in our
     * case, an integer ID for the resource. eg: /<endpoint>/<verb>/<arg0>/<arg1>
     * or /<endpoint>/<arg0>
     */
    protected $args = Array();
    /**
     * Property: file
     * Stores the input of the PUT request
     */
     protected $file = Null;

    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct($request) {
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

}

class Form_Settings_API extends Ninja_Forms_Admin_Rest_API
{
    protected $User;

    public function __construct($request, $origin) {
        parent::__construct($request);

        // Abstracted out for example
        //$APIKey = new Models\APIKey();
        //$User = new Models\User();

        
        /*

        if (!array_key_exists('apiKey', $this->request)) {
            throw new Exception('No Ninja_Forms_Admin_Rest_API Key provided');
        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
            throw new Exception('Invalid Ninja_Forms_Admin_Rest_API Key');
        } else if (array_key_exists('token', $this->request) &&
             !$User->get('token', $this->request['token'])) {

            throw new Exception('Invalid User Token');
        }

        $this->User = $User;
        */
    }

	protected function form_settings() {
        global $ninja_forms_form_settings;
        do_action( 'ninja_forms_admin_init' );

     	switch( $this->method ) {
     		case 'GET':
                $tab = $this->request['tab'];
                $form_id = $this->request['form_id'];
     			if ( isset ( $this->request['form_id'] ) ) {
     				$form_row = ninja_forms_get_form_by_id( $form_id );
                    $form_data = $form_row['data'];
     			}
				$args = array();
                foreach( $ninja_forms_form_settings[$tab] as $id => $setting ){
                   
                    if ( isset ( $setting['type'] ) ) {
                        $type = $setting['type'];
                    } else {
                        $type = '';
                    }

                    if ( isset ( $setting['label'] ) ) {
                        $label = $setting['label'];
                    } else {
                        $label = '';
                    }

                    if ( isset ( $setting['options'] ) ) {
                        $options = $setting['options'];
                    } else {
                        $options = '';
                    }
                    
                    if ( isset ( $setting['class'] ) ) {
                        $class = $setting['class'];
                    } else {
                        $class = '';
                    }

                    if ( isset ( $setting['desc'] ) ) {
                        $desc = $setting['desc'];
                    } else {
                        $desc = '';
                    }

                    if ( isset ( $form_data[$id] ) ) {
                        $current_value = $form_data[$id];
                    } else if ( isset ( $setting['default_value'] ) ) {
                        $current_value = $setting['default_value'];
                    } else {
                        $current_value = '';
                    }

                    $current_value = apply_filters( 'ninja_forms_rest_get_value', $current_value, $id, $form_id );

                    $args[] = array(
                        'id' => $id,
                        'type' => $type,
                        'label' => $label,
                        'options' => $options,
                        'current_value' => $current_value,
                        'class' => $class,
                        'desc' => $desc,
                    ); 
                }
	        	
                return $args;
                break;
     		case 'PUT':
     			$data = json_decode( $this->file );
     			$current_value = $data->current_value;
     			$form_setting = $data->id;
     			$form_id = $data->form_id;
                $current_value = apply_filters( 'ninja_forms_rest_put_value', $current_value, $form_setting, $form_id );
     			$args = array(
     				'form_id' => $form_id,
     				'update' => array(
     					$form_setting => $current_value,
     				),
     			);
    			ninja_forms_update_form_setting( $args );
                $current_value = apply_filters( 'ninja_forms_rest_put_return_value', $current_value, $form_setting, $form_id );
                $data->current_value = $current_value;
     			return $data;
     			break;
		}
	}
 }