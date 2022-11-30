<?php

/**
 * Class OST_API_Controller
 */

class OST_API_Controller {

    /**
     * @var OST_API_Controller
     */
    protected static $instance = null;

    /**
     * Prevent Instance of Class
     */
    private function __construct() {}

    /**
     * Singleton instance
     *
     * @return  self
     */
	public static function instance() {
		if( null === self::$instance ) {
			self::$instance = new self();
        }
        return self::$instance;
	}

    /* ==============================================================================
        API Configurations
      ==============================================================================  */
    
    /**
     * Set the API URL
     * 
     * @return string - the full URL to use
     */
    
    public function get_url() {
        $options = get_option( 'OST_Connector_settings' );
        return ('https://' . $options['url'] . '/api/http.php/tickets.json');
    }
    

    /**
     * Set API configuration to send with HTTP request
     * 
     * @param data - required data to post to server (expects json)
     * 
     * @return array - request arguments to be set as second arg in wp_remote_get 
     * 
     * Reference: https://developer.wordpress.org/reference/functions/wp_remote_get/
     */
    
	
	public function api_options($args)
    {
        $options = get_option( 'OST_Connector_settings' );
        
        $data = array_merge($args, [
            'alert' => false,
            'autorespond' => true,
            'source' => 'API',
            'ip' => $_SERVER['REMOTE_ADDR'],
            'website' => $_SERVER['SERVER_NAME']
        ]);
        
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'X-API-Key' => $options['api_key']
            ],
            'body' => json_encode($data),
        ];
    }

    /* ==============================================================================
        CRUD Functions
        
        @return mixed (Returns the value encoded in json to appropriate PHP type)
        
        Reference: https://www.php.net/manual/en/function.json-decode.php
      ==============================================================================  */

    public function send_ticket($data) {
        return wp_remote_post(self::get_url(), self::api_options($data));
    }
}

/**
 * Returns main instance of OST_API_Controller
 * 
 * @return OST_API_Controller
 */
 
function OST_API_Controller() {
	return OST_API_Controller::instance();
}

OST_API_Controller();