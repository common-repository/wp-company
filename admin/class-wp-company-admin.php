<?php
/**
 * WP Company
 *
 * @package   WP_Company_Admin
 * @author    Aaron Lee <aaron.lee@buooy.com>
 * @license   GPL-2.0+
 * @link      http://buooy.com
 * @copyright 2013 Buooy
 * @copyright 2013 Buooy
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * administrative side of the WordPress site.
 *
 * If you're interested in introducing public-facing
 * functionality, then refer to `class-plugin-name.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package WP_Company_Admin
 * @author  Aaron Lee <aaron.lee@buooy.com>
 */
class WP_Company_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 */
		$plugin = WP_Company::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		/*
		 * Define custom functionality.
		 *
		 * Read more about actions and filters:
		 * http://codex.wordpress.org/Plugin_API#Hooks.2C_Actions_and_Filters
		 */
		add_action( 'admin_init', array( $this, 'init_settings' ) );
		
	}
	
	/* Initializes the settings page to the company details page */
	public function init_settings() {
		
		add_action( 'wp_ajax_settings_handling_action', array( $this,'settings_ajax_handling_callback' ) );
		
		// Main Company Information
		$this->main_company_info_init();
		// Social Media Information
		$this->social_init();

		// Help Information
		$this->help_init();
	}

	/**
	 *	Help
	 */
	public function help_init(){
		$plugin = WP_Company::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$setting_section_id = 'wp_company_help';
		$setting_section_name = $this->plugin_slug.'-help';

		// Add Help Information Settings
		add_settings_section(
			$setting_section_id,
			'',
			array( $this, 'help_section_callback_function' ),
			$setting_section_name
		);
	}

	
	/**
	 *	Social Media Information
	 *
	 *	List of Social Media Information Options
	 *	1.	facebook
	 	2.	twitter
	 	3.	googleplus
	 	4.	linkedin (for company)
	 	5.	pinterest
	 	6.	tumblr
	 	7. 	vimeo
	 	8.	youtube
	 *
	 */
	public function social_init(){
		$plugin = WP_Company::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$setting_section_id = 'wp_company_social';
		$setting_section_name = $this->plugin_slug.'-social';
		$social_input_size = 20;

		// Add Social Information Settings
		add_settings_section(
			$setting_section_id,
			'Social Information',
			array( $this, 'social_section_callback_function' ),
			$setting_section_name
		);

		// Add facebook
		$company_facebook_id = 'company_facebook';
		$company_facebook_title = 'Company Facebook ';
		add_settings_field(   
			$company_facebook_id,                     	// ID used to identify the field throughout the theme  
			$company_facebook_title,                    // The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         					// The name of the section to which this field belongs  
			// The array of arguments to pass to the callback. In this case, just a description. 
			//	0:	Settings Name
			//	1:	Settings ID
			//	2:	Settings Classes
			//	3:	Settings Type e.g. checkbox, text etc
			//	4:	Settings size
			//	5:	Settings value
			//	6:	Settings label
			array(                              		 
				$company_facebook_title,
				$company_facebook_id,
				'',
				'text',
				$social_input_size,
				get_option($company_facebook_id),
				'http://facebook.com/'
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_facebook_id  
		); 

		// Add twitter
		$company_twitter_id = 'company_twitter';
		$company_twitter_title = 'Company Twitter';
		add_settings_field(   
			$company_twitter_id,                     	// ID used to identify the field throughout the theme  
			$company_twitter_title,           			// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs 
			array(                              		 
				$company_twitter_title,
				$company_twitter_id,
				'',
				'text',
				$social_input_size,
				get_option($company_twitter_id),
				'http://twitter.com/'
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_twitter_id  
		); 

		// Add googleplus
		$company_googleplus_id = 'company_googleplus';
		$company_googleplus_title = 'Company Google Plus';
		add_settings_field(   
			$company_googleplus_id,                     	// ID used to identify the field throughout the theme  
			$company_googleplus_title,           			// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs 
			array(                              		 
				$company_googleplus_title,
				$company_googleplus_id,
				'',
				'text',
				$social_input_size,
				get_option($company_googleplus_id),
				'https://plus.google.com/'
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_googleplus_id  
		); 

		// Add linkedin
		$company_linkedin_id = 'company_linkedin';
		$company_linkedin_title = 'Company Linkedin';
		add_settings_field(   
			$company_linkedin_id,                     	// ID used to identify the field throughout the theme  
			$company_linkedin_title,           			// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs 
			array(                              		 
				$company_linkedin_title,
				$company_linkedin_id,
				'',
				'text',
				$social_input_size,
				get_option($company_linkedin_id),
				'http://linkedin.com/company/'
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_linkedin_id  
		); 

		// Add pinterest
		$company_pinterest_id = 'company_pinterest';
		$company_pinterest_title = 'Company Pinterest';
		add_settings_field(   
			$company_pinterest_id,                     	// ID used to identify the field throughout the theme  
			$company_pinterest_title,           			// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs 
			array(                              		 
				$company_pinterest_title,
				$company_pinterest_id,
				'',
				'text',
				$social_input_size,
				get_option($company_pinterest_id),
				'http://pinterest.com/'
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_pinterest_id  
		); 

		// Add tumblr
		$company_tumblr_id = 'company_tumblr';
		$company_tumblr_title = 'Company Tumblr';
		add_settings_field(   
			$company_tumblr_id,                     	// ID used to identify the field throughout the theme  
			$company_tumblr_title,           			// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs 
			array(                              		 
				$company_tumblr_title,
				$company_tumblr_id,
				'',
				'text',
				$social_input_size,
				get_option($company_tumblr_id),
				'http://',
				'.tumblr.com'
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_tumblr_id  
		); 

		// Add vimeo
		$company_vimeo_id = 'company_vimeo';
		$company_vimeo_title = 'Company Vimeo';
		add_settings_field(   
			$company_vimeo_id,                     	// ID used to identify the field throughout the theme  
			$company_vimeo_title,           			// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs 
			array(                              		 
				$company_vimeo_title,
				$company_vimeo_id,
				'',
				'text',
				$social_input_size,
				get_option($company_vimeo_id),
				'http://vimeo.com/'
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_vimeo_id  
		); 

		// Add youtube
		$company_youtube_id = 'company_youtube';
		$company_youtube_title = 'Company YouTube';
		add_settings_field(   
			$company_youtube_id,                     	// ID used to identify the field throughout the theme  
			$company_youtube_title,           			// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs 
			array(                              		 
				$company_youtube_title,
				$company_youtube_id,
				'',
				'text',
				$social_input_size,
				get_option($company_youtube_id),
				'http://youtube.com/user/ '
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_youtube_id  
		); 

	}

	/**
	 *	Main Company Information
	 *
	 *	List of Company Information Options
	 *	1.	company_name
	 	2.	company_address_1
	 	3.	company_address_2
	 	4.	company_country
	 	5.	company_state
	 	6.	company_city
	 	7.	company_postal
	 *
	 */
	public function main_company_info_init(){
		$plugin = WP_Company::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$setting_section_id = 'wp_company_info';
		$setting_section_name = $this->plugin_slug.'-general';

		// Add Main Company Information Settings
		add_settings_section(
			$setting_section_id,
			'Main Company Information',
			array( $this, 'main_company_info_section_callback_function' ),
			$setting_section_name
		);
		// Add Company Name
		$company_name_id = 'company_name';
		$company_name_title = 'Company Name';
		add_settings_field(   
			$company_name_id,                     		// ID used to identify the field throughout the theme  
			$company_name_title,                     		// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		 	// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs  
			// The array of arguments to pass to the callback. In this case, just a description. 
			//	0:	Settings Name
			//	1:	Settings ID
			//	2:	Settings Classes
			//	3:	Settings Type e.g. checkbox, text etc
			//	4:	Settings size
			//	5:	Settings value
			array(                              		 
				$company_name_title,
				$company_name_id,
				'',
				'text',
				'',
				get_option($company_name_id)
			)  
		); 
		register_setting(  
			$setting_section_name,  
			$company_name_id  
		);  

		// Add Company Address 1
		$company_address_1_id = 'company_address_1';
		$company_address_1_title = 'Company Address 1';
		add_settings_field(   
			$company_address_1_id,                     		// ID used to identify the field throughout the theme  
			$company_address_1_title,                     	// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		 	// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs
			array(                              		 
				$company_address_1_title,
				$company_address_1_id,
				'',
				'text',
				'',
				get_option($company_address_1_id)
			)); 
		register_setting(  
			$setting_section_name,  
			$company_address_1_id  
		);  

		// Add Company Address 2
		$company_address_2_id = 'company_address_2';
		$company_address_2_title = 'Company Address 2';
		add_settings_field(   
			$company_address_2_id,                     		// ID used to identify the field throughout the theme  
			$company_address_2_title,                     	// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		 	// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs
			array(                              		 
				$company_address_2_title,
				$company_address_2_id,
				'',
				'text',
				'',
				get_option($company_address_2_id)
			)); 
		register_setting(  
			$setting_section_name,  
			$company_address_2_id  
		); 

		// Add Company country
		$company_country_id = 'company_country';
		$company_country_title = 'Company Country';
		add_settings_field(   
			$company_country_id,                     		// ID used to identify the field throughout the theme  
			$company_country_title,                     	// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		 	// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs
			array(                              		 
				$company_country_title,
				$company_country_id,
				'',
				'text',
				'',
				get_option($company_country_id)
			)); 
		register_setting(  
			$setting_section_name,  
			$company_country_id  
		); 

		// Add Company State
		$company_state_id = 'company_state';
		$company_state_title = 'Company State';
		add_settings_field(   
			$company_state_id,                     		// ID used to identify the field throughout the theme  
			$company_state_title,                     	// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		 	// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs
			array(                              		 
				$company_state_title,
				$company_state_id,
				'',
				'text',
				'',
				get_option($company_state_id)
			)); 
		register_setting(  
			$setting_section_name,  
			$company_state_id  
		);

		// Add Company City
		$company_city_id = 'company_city';
		$company_city_title = 'Company City';
		add_settings_field(   
			$company_city_id,                     		// ID used to identify the field throughout the theme  
			$company_city_title,                     	// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		 	// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs
			array(                              		 
				$company_city_title,
				$company_city_id,
				'',
				'text',
				'',
				get_option($company_city_id)
			)); 
		register_setting(  
			$setting_section_name,  
			$company_city_id  
		); 

		// Add Company Postal Code
		$company_postal_id = 'company_postal';
		$company_postal_title = 'Company Postal Code';
		add_settings_field(   
			$company_postal_id,                     		// ID used to identify the field throughout the theme  
			$company_postal_title,                     	// The label to the left of the option interface element  
			array($this, 'build_settings_callback'),	// The name of the function responsible for rendering the option interface  
			$setting_section_name,                		 	// The page on which this option will be displayed  
			$setting_section_id,         				// The name of the section to which this field belongs
			array(                              		 
				$company_postal_title,
				$company_postal_id,
				'',
				'text',
				'',
				get_option($company_postal_id)
			)); 
		register_setting(  
			$setting_section_name,  
			$company_postal_id  
		); 


	}
	public function main_company_info_section_callback_function(){
	}
	public function social_section_callback_function(){
	}
	public function help_section_callback_function(){

		// Display the help information
		include_once('views/help.php');
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), WP_Company::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), microtime() );
			wp_localize_script(  
				$this->plugin_slug.'-admin-script',
				'wp_company_ajax',  
				array(  
					'ajaxurl' => admin_url( 'admin-ajax.php' ), // URL to WordPress ajax handling page  
					'nonce' => wp_create_nonce('wp_company_nonce_action')  
				)  
			);  
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 */
		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Company Details', $this->plugin_slug ),
			__( 'Company Details', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 *
	 *	This builds the settings fields
	 *
	 *	0:	Settings Name
	 *	1:	Settings ID
	 *	2:	Settings Classes
	 *	3:	Settings Type e.g. checkbox, text etc
	 *	4:	Settings size e.g. 20,100
	 *	5:	Settings Value
	 *	6:	Settings Label
	 *	7:	Settings Label - after
	 */
	public function build_settings_callback($args){
	
		$html = '';
		$settings_size = filter_var($args[4], FILTER_VALIDATE_INT) ? $args[4] : 40;
		
		if( $args[3] == 'text' || $args[3] == 'password' || $args[3] == 'hidden' ){
		
			if( isset($args[6]) ) {
				$html .= '	<label for="'.$args[1].'">
							'.$args[6].'
						</label>';
			}
			$html .= '<input size = "'.$settings_size.'"
							type="'.$args[3].'" 
							class="'.$args[2].'" 
							id="'.$args[1].'" 
							name="'.$args[1].'" 
							value="'.$args[5].'"/>';
			if( isset($args[7]) ) {
				$html .= '	<label for="'.$args[1].'">
							'.$args[7].'
						</label>';
			}
		}

		echo $html;  
	}
	
	
	
	
	
	/**
	 *
	 *	Handles the ajax saving of data
	 *
		This is a list of approved options that can be used with the plugin
		List of Company Information Options
	 	1.	company_name
	 	2.	company_address_1
	 	3.	company_address_2
	 	4.	company_country
	 	5.	company_state
	 	6.	company_city
	 	7.	company_postal
	 */
	public function settings_ajax_handling_callback(){

		check_ajax_referer('wp_company_nonce_action');
		
		// Proceed with the validation and update of the options
		global $wpdb; // this is how you get access to the database
		$options_list = array(
			// Company Info
			'company_name',
			'company_address_1',
			'company_address_2',
			'company_country',
			'company_state',
			'company_city',
			'company_postal',
			// Company Social
			'company_facebook',
	 		'company_twitter',
	 		'company_googleplus',
	 		'company_linkedin',
	 		'company_pinterest',
	 		'company_tumblr',
	 		'company_vimeo',
	 		'company_youtube'

		);

		$return = '';

		// Validation of information
		foreach( $_POST as $key => $value ){

			// Do not include the nonce and action
			if( $key == 'action' || $key == '_ajax_nonce' )	continue;

			// Add the information to the options
			if( in_array( $key, $options_list ) ){
				update_option( $key, $value );
			}

		}
	
		echo json_encode($return);

		die(); // this is required to return a proper result
	}
}
