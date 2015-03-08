<?php
    /*
    Plugin Name: WP - Jira Issue Collector
    Plugin URI: https://github.com/crowdpolicy/CP-AutoJira
    Description: Insert JIRA HELPDESC INTEGRATION
    Author: Crowdpolicy by Margarit Koka
    Version: 0.2
    Author URI: http://crowdpolicy.com
    */



	//Register CSS and JS files
	function jirector_scripts() {
		wp_register_style( 'irector_css',  plugin_dir_url( __FILE__ ) . 'css/style.css' );
	  	wp_enqueue_style( 'jirector_css' );

	  	/* No need for any JS file for the moment */
	  	//wp_enqueue_script( 'jirector_js', plugin_dir_url( __FILE__ ) . 'js/jirector.js', array('jquery'), true );
	  }
	add_action( 'wp_enqueue_scripts', 'jirector_scripts' );

	//Hook Jira jQuery option on <head>
	function insert_jirector() {

		$traw = '<script type="text/javascript">jQuery.ajax({';
	    $traw .= 'url: "'.get_option('url_option_field').'",';
		$traw .= 'type: "get",';
		$traw .= 'cache: true,';
		$traw .= 'dataType: "script"';
		$traw .= '});';
		$traw .= '</script>';

		echo $traw;

	}
	add_action('wp_head', 'insert_jirector'); //Hook on head

	?>
	<?php
	// jirector settings menu
	add_action('admin_menu', 'jirector_menu');

	function jirector_menu() {

		//top-level menu
		add_menu_page('Jira Issue Collector', 'CP-WPJIRA', 'administrator', __FILE__, 'jirector_settings_page');

		//call register jirector_settings function
		add_action( 'admin_init', 'jirector_settings' );
	}


	function jirector_settings() {
		//register
		register_setting( 'jirector-settings-group', 'url_option_field' );


	    $filePath = plugins_url( 'css/style.css', __FILE__);
	    add_editor_style($filePath);
	}

	function jirector_settings_page() {
		$theJurl = get_option('url_option_field');
	?>
		<div class="wrap">
			<h2>CP Jira Issue Collector Settings</h2>

			<form method="post" action="options.php">
			    <?php settings_fields( 'jirector-settings-group' ); ?>
			    <?php do_settings_sections( 'jirector-settings-group' ); ?>
			    <table class="form-table">
			        <tr valign="top">
			        <th scope="row">Issue Collector Unique URL</th>
			        <td><input type="text" name="url_option_field" value="<?php echo esc_attr( get_option('url_option_field') ); ?>" /></td>
			        </tr>

			    </table>
			    <?php if ($theJurl  == !''): ?>
					<div>Your Current URL is ==> <?php echo get_option('url_option_field'); ?></div>
				<?php endif; ?>
			    <?php
				    submit_button(); ?>

			</form>
		</div>
<?php } ?>