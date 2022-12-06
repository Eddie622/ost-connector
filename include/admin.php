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
        $options = get_option( 'OST_Connector_settings' );
        
        // Handle POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
            $args = [];
            
            // var_dump($_POST);
            
            // Validate/Sanitize/Process Input
            empty($_POST['name']) ? $errors[] = 'name' : $args['name'] = esc_html($_POST['name']);
            empty($_POST['email']) ? $errors[] = 'email' : $args['email'] = esc_html($_POST['email']);
            empty($_POST['subject']) ? $errors[] = 'subject' : $args['subject'] = esc_html($_POST['subject']);
            empty($_POST['message']) ? $errors[] = 'message' : $args['message'] = esc_html($_POST['message']);
            
            // var_dump($_FILES['attachments']);
            
            // if(!empty($_FILES['attachments'])):
            //     $attachments = $_FILES['attachments'];
            //     is_array($attachments) ?: $attachments = array($attachments);
                
            //     if(!empty($attachments['name'])):
            //         $args['attachments'] = array();
            //         for ($i = 0; $i <= count($attachments['name'])-1; $i++):
            //             $args['attachments'][] = array( $attachments['name'][$i] => "data:{$attachments['type'][$i]};base64,".base64_encode($attachments['tmp_name'][$i]));
            //         endfor;
            //     endif;
            // endif;

            // var_dump($args['attachments']);
            
            // Send to Helpdesk
            if(empty($errors)):
                $response = OST_API_Controller()->send_ticket($args);
                wp_remote_retrieve_response_code($response) == '201' ? $success = true : $success = false;
            endif;
        endif;
        
        // Display page
        include_once(OST_CONNECTOR_DIR . 'templates/admin-page.php');
        
        // var_dump($response);
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
