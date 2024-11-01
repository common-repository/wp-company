<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   wp_company
 * @author    Aaron Lee <aaron.lee@buooy.com>
 * @license   GPL-2.0+
 * @link      http://buooy.com
 * @copyright 2013 Buooy
 */

?>

<?php 

Class WPCompanyView{

	private $general_settings_key = 	'general';
	public $plugin_settings_tabs = 	array(
										'general' 	=> 	'General',
										'social'	=>	'Social',
										'help'	=>	'Help',
									);
	private $plugin_options_key = 'wp-company';
	public $tab = '';

	// Construct
	public function __construct(){
		if( isset( $_GET['tab'] ) ){
			$this->tab = $_GET['tab'];
		}
		else{
			$this->tab = $this->general_settings_key; 
		}

		$this->plugin_options_page();
	}

	// Plugin Options Tabs
	public function plugin_options_tabs() {
	    $current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_settings_key;

	    screen_icon();
	    echo '<h2 class="nav-tab-wrapper">';
	    foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
	        $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
	        echo 	'<a class="nav-tab ' . $active . 
	        		'" href="?page=' . $this->plugin_options_key . 
	        		'&tab=' . $tab_key . '">' . $tab_caption . '</a>';
	    }
	    echo '</h2>';
	}

	// Displays the plugin options page
	public function plugin_options_page() {
	    $this_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_settings_key;
	    ?>
	    <div class="wrap">
	        <?php $this->plugin_options_tabs(); ?>
	        <?php
	        	if( $this_tab != 'help' ){
	        ?>
	        		<form method="post" id="wp-company-form">	
					<input type="hidden" name="action" value="settings_handling_action">
					<input type="hidden" name="_ajax_nonce" value="<?php echo wp_create_nonce('wp_company_nonce_action');?>">
	        <?php
	        	}
	        ?>
	            <?php 
	            	//do_settings_sections( 'wp-company-security' );
	            	do_settings_sections( 'wp-company-'.$this_tab );
	            ?>
	        <?php
	        	if( $this_tab != 'help' ){
	        ?>
	            <p>
	            	<?php submit_button('Save Changes', 'primary', 'submit', '', array('id'=>'wp-company-submit') ); ?>
	            </p>
	        </form>
	        <?php
	        	}
	        ?>
	    </div>
	    <?php
	}

}

new WPCompanyView;


?>
