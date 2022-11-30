<?php

/**
 * Class OST_Admin
 */

class OST_Admin {

    /**
     * @var OST_Admin
     */
    protected static $instance = null;

    /**
     * Constructor
     * 
     * @return  void
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

    /**
     * Action Hook for Admin Menu
     */
    public function OST_Helpdesk_Menu() {
        // Add menu
	    $helpdesk = add_menu_page( 
            'Helpdesk', 
            'Helpdesk', 
            'manage_options', 
            'ost-connector/ost-connector-admin.php', 
            [$this, 'OST_admin_page'], 
            'dashicons-tickets', 
            6  
        );
        // Enqueue Assets
        add_action( 'load-' . $helpdesk, [OST_Connector::instance(), 'load_admin_styles'] );
    }

    public function OST_admin_page(){
        // Initialize
        $errors = [];
        
        // Handle POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
            $args = [];
            
            var_dump($_POST);
            var_dump($_FILES);
            
            // Validate/Sanitize Input
            empty($_POST['name']) ? $errors[] = 'name' : $args['name'] = esc_html($_POST['name']);
            empty($_POST['email']) ? $errors[] = 'email' : $args['email'] = esc_html($_POST['email']);
            empty($_POST['subject']) ? $errors[] = 'subject' : $args['subject'] = esc_html($_POST['subject']);
            empty($_POST['message']) ? $errors[] = 'message' : $args['message'] = esc_html($_POST['message']);
            empty($_FILES['attachments']) ?: $args['attachments'] = base64_encode($_FILES['attachments']);
            
            // Send to Helpdesk
            if(empty($errors)):
                $response = OST_API_Controller()->send_ticket($args);
                wp_remote_retrieve_response_code($response) == '201' ? $success = true : $success = false;
            endif;
        endif;
        
        // Display page
        include_once(OST_CONNECTOR_DIR . 'templates/admin-page.php');
        
    }
}

/**
 * Returns main instance of Admin
 * 
 * @return OST_Admin
 */
 
function OST_Admin() {
	return OST_Admin::instance();
}
