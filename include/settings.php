<?php

/**
 * Class Settings
 */

class OST_Settings {
    /**
     * @var OST_Settings
     */
    protected static $instance = null;

    /**
     * Constructor
     * 
     * @return  void
     */
    private function __construct() {
        add_action( 'admin_init', [$this, 'OST_register_settings'] );
    }

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

    public function OST_add_settings_page() {
      $settings = add_options_page(
        'OST Connector Settings',
        'OST Connector',
        'manage_options',
        'ost-connector.php',
        [$this, 'OST_settings_page']
      );
      // Enqueue Assets
      add_action( 'load-' . $settings, [OST_Connector::instance(), 'load_admin_styles'] );
    }

    public function OST_settings_page(){
        include_once(OST_CONNECTOR_DIR . 'templates/settings-page.php');
    }

    function OST_register_settings() {
     register_setting(
          'OST_Connector_settings',
          'OST_Connector_settings',
          'OST_validate_plugin_settings'
      );
      add_settings_section(
          'section_one',
          '',
          [$this, 'OST_render_section_one_text'],
          'OST_Connector'
      );
      add_settings_field(
          'name',
          'Helpdesk Name',
          [$this, 'OST_render_name_field'],
          'OST_Connector',
          'section_one'
      );
      add_settings_field(
          'url',
          'Helpdesk URL',
          [$this, 'OST_render_url_field'],
          'OST_Connector',
          'section_one'
      );
      add_settings_field(
          'api_key',
          'API Key',
          [$this, 'OST_render_api_key_field'],
          'OST_Connector',
          'section_one'
      );
    //   add_settings_field(
    //       'dev_notes',
    //       'Dev Notes',
    //       [$this, 'OST_render_dev_notes_field'],
    //       'OST_Connector',
    //       'section_one'
    //   );
    }

    public function OST_validate_plugin_settings( $input ) {
        $output['api_key'] = sanitize_text_field( $input['api_key'] );
        return $output;
    }
    
    public function OST_render_section_one_text(){
        printf('<p>General Configurations</p>');
    }
    
    public function OST_render_name_field() {
      $options = get_option( 'OST_Connector_settings' );
      printf(
        '<input type="text" name="%s" value="%s" />',
        esc_attr( 'OST_Connector_settings[name]' ),
        esc_attr( $options['name'] )
      );
    }

    public function OST_render_api_key_field() {
      $options = get_option( 'OST_Connector_settings' );
      printf(
        '<input type="text" name="%s" value="%s" />',
        esc_attr( 'OST_Connector_settings[api_key]' ),
        esc_attr( $options['api_key'] )
      );
    }
    
    public function OST_render_url_field() {
      $options = get_option( 'OST_Connector_settings' );
      printf(
        '<input type="text" name="%s" value="%s" />',
        esc_attr( 'OST_Connector_settings[url]' ),
        esc_attr( $options['url'] )
      );
    }
    
    public function OST_render_dev_notes_field() {
      $options = get_option( 'OST_Connector_settings' );
      printf(
        '<textarea name="%s">%s</textarea>',
        esc_attr( 'OST_Connector_settings[dev_notes]' ),
        esc_attr( $options['dev_notes'] )
      );
    }
}

/**
 * Returns main instance of Settings
 * 
 * @return  OST_Settings
 */
 
function OST_Settings() {
	return OST_Settings::instance();
}
