<?php
/*
Plugin Name: Kv reCaptcha
Plugin URI: http://wordpress.org/plugins/kv-recaptcha	
Description: A minimal file to add reCaptcha with your WordPress Registration form, <a href="http://www.kvcodes.com" target="_blank" > Read more </a> 
Version: 1.0
Author: Kvvaradha
Author URI: http://profiles.wordpress.org/kvvaradha
*/

define('KV_RECAPTCHA_URL', plugin_dir_url( __FILE__ ));

//require_once(KV_RECAPTCHA_URL.'/recaptchalib.php');

function kv_user_registration_form() { ?>
    <p>
		<label for="mob_no">Validation<br>
		<?php kv_recaptcha(); ?>
	</p>
<?php 
} 
if (get_option('kv_recaptcha_enable_signup') == true && get_option('kv_recaptcha_public_key')) {
	add_action('register_form', 'kv_user_registration_form');
	add_filter('registration_errors','kv_login_errors');
}

function kv_login_errors( $errors ) {
	if ( isset( $_POST["log"] ) && ! kv_recaptcha_check() ) {
		$errors->add( 'captcha_error' ,  __("<strong>Error:</strong> the Captcha didn’t verify.",'kv_recaptcha') );
	}
	return $errors;
}

function kv_recaptcha_check() {
	$private_key = get_option( 'kv_recaptcha_privatekey' );
	$response = recaptcha_check_answer( $private_key,	$_SERVER["REMOTE_ADDR"],	$_POST["recaptcha_challenge_field"],	$_POST["recaptcha_response_field"]);
	if ( ! $response->is_valid )
		return $response->error;
	else 
		return $response->is_valid;
}
	/*
function kv_save_registration_form_data($user_id) {
	$user = array();
	
	$user['ID'] = $user_id;
	$user['mobile_no'] = $_POST['mob_no'];	
	
	// Adding tyhe custom field to database
	$kvads= add_user_meta( $user_id, 'mobile_no', $user['mobile_no']);		
}
add_action('user_register', 'kv_save_registration_form_data', 10, 1 );
*/

// contains the reCaptcha anti-spam system. Called on reg pages
function kv_recaptcha() {

    // process the reCaptcha request if it's been enabled
    if (get_option('kv_recaptcha_enable_signup') == true && get_option('kv_recaptcha_theme') && get_option('kv_recaptcha_public_key')) :
?>
        <script type="text/javascript">
        // <![CDATA[
         var RecaptchaOptions = {
            custom_translations : {
                instructions_visual : "<?php _e('Type the two words:','kv_recaptcha') ?>",
                instructions_audio : "<?php _e('Type what you hear:','kv_recaptcha') ?>",
                play_again : "<?php _e('Play sound again','kv_recaptcha') ?>",
                cant_hear_this : "<?php _e('Download sound as MP3','kv_recaptcha') ?>",
                visual_challenge : "<?php _e('Visual challenge','kv_recaptcha') ?>",
                audio_challenge : "<?php _e('Audio challenge','kv_recaptcha') ?>",
                refresh_btn : "<?php _e('Get two new words','kv_recaptcha') ?>",
                help_btn : "<?php _e('Help','kv_recaptcha') ?>",
                incorrect_try_again : "<?php _e('Incorrect. Try again.','kv_recaptcha') ?>",
            },
            theme: "<?php echo get_option('kv_captcha_theme') ?>",
            lang: "en",
            tabindex: 5
         };
        // ]]>
        </script>

        <p>
        <?php
        // let's call in the big boys. It's captcha time.
        require_once('recaptchalib.php');
        echo recaptcha_get_html(get_option('kv_recaptcha_public_key'));
        ?>
        </p>

<?php
    endif;  // end reCaptcha

}
/*
if(!function_exists('kv_admin_menu_captcha')) {
	function kv_admin_menu_captcha() { 		
		add_menu_page('KV reCaptcha', 'KV reCaptcha', 'manage_options', 'kv_recaptcha' , 'kv_recaptcha_admin', KV_RECAPTCHA_URL.'/images/kv_logo.png', 67);	
	}
add_action('admin_menu', 'kv_admin_menu_captcha');
}
*/


if(!function_exists('kv_admin_menu')) {
	function kv_admin_menu() { 		
		add_menu_page('Kvcodes', 'Kvcodes', 'manage_options', 'kvcodes' , 'kv_codes_plugins', KV_RECAPTCHA_URL.'/images/kv_logo.png', 66);	
		add_submenu_page( 'kvcodes', 'KV reCaptcha', 'KV reCaptcha', 'manage_options', 'kv_plugin_hider', 'kv_list_plugins' );
	}
add_action('admin_menu', 'kv_admin_menu');

function kv_codes_plugins() {

?>
 <div class="wrap">
        <div class="icon32" id="icon-tools"><br/></div>
        <h2><?php _e('KvCodes', 'kvcodes') ?></h2>		
		<div class="welcome-panel">
								<?php //kv_admin_thirty_day_chart () ; ?>
								Thank you for using Kvcodes Plugins . Here is my few Plugins work .MY plugins are very light weight and Simple.  <p>
								<a href="http://www.kvcodes.com/" target="_blank" ><h3> Visit My Blog</h3></a></p> 
								</div> 
		<div id="poststuff" > 
			<div id="post-body" class="metabox-holder columns-2" >
				<div id="post-body-content" > 
					<div class="meta-box-sortables"> 
						<div id="dashboard_right_now" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle"  ><img src="<?php echo KV_RECAPTCHA_URL.'/images/kv_logo.png'; ?>" >  My plugins </h3> 
							<div class="inside" style="padding: 10px; "> 
								
								<?php 
									$kv_wp =  kv_get_web_page('http://profiles.wordpress.org/kvvaradha'); 
									
									 $kv_first_pos = strpos($kv_wp['content'], '<div id="content-plugins" class="info-group plugin-theme main-plugins inactive">');
									
									$kv_first_trim = substr($kv_wp['content'] , $kv_first_pos ); 
										
									$kv_sec_pos = strpos($kv_first_trim, '</div>');
									
									$kv_sec_trim = substr($kv_first_trim ,0, $kv_sec_pos );  
									
									echo $kv_sec_trim; 					?> 
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div> 

</div> <!-- /wrap -->
<?php

}

function kv_get_web_page( $url )
{
	$options = array(
		CURLOPT_RETURNTRANSFER => true,     // return web page
		CURLOPT_HEADER         => false,    // don't return headers
		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
		CURLOPT_ENCODING       => "",       // handle compressed
		CURLOPT_USERAGENT      => "spider", // who am i
		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
		CURLOPT_TIMEOUT        => 120,      // timeout on response
		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	);

	$ch      = curl_init( $url );
	curl_setopt_array( $ch, $options );
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
}

} else {
	function kv_admin_submenu_recaptcha() { 		
		add_submenu_page( 'kvcodes', 'KV reCaptcha', 'KV reCaptcha', 'manage_options', 'kv_plugin_hider', 'kv_list_plugins' );
	}
add_action('admin_menu', 'kv_admin_submenu_recaptcha');
	
}

add_action('admin_init', 'kv_admin_recaptcha_register');

function kv_admin_recaptcha_register() {
	register_setting('kv_recaptcha' , 'kv_recaptcha_public_key');
	register_setting('kv_recaptcha' , 'kv_recaptcha_privatekey');
	register_setting('kv_recaptcha' , 'kv_recaptcha_theme');
	register_setting('kv_recaptcha' , 'kv_recaptcha_enable_signup');
	//register_setting('kv_recaptcha' , 'kv_recaptcha_theme');
}

function kv_recaptcha_admin() { ?>
 <div class="wrap">
        <div class="icon32" id="icon-tools"><br/></div>
        <h2><?php _e('Kv reCaptcha', 'kv_recaptcha') ?></h2>

		<div class="welcome-panel">
		<?php //kv_admin_thirty_day_chart () ; ?>
		Thank you for using KV reCaptcha This is a initial Version. So you have to write more codes.<br> In future, With few clicks and drag drop you can create a Nice WP Plugin.  <p>		 
		</div> 
		<div id="dashboard-widget-wrap" >
			<div id="dashboard-widgets" class="metabox-holder columns-2" >
				<div id="postbox-container-1" class="postbox-container" > 
					<div class="meta-box-sortables"> 
						<div id="dashboard_right_now" class="postbox">
							<div class="handlediv" > <br> </div>
							<h3 class="hndle" > KV reCaptcha Settings </h3> 
							<div class="inside" style="padding: 5px; " > 
								<form method="post" action="options.php">
								    <?php settings_fields( 'kv_recaptcha' ); ?>
								    <?php do_settings_sections( 'kv_recaptcha' ); ?>
								    <table class="form-table">								                 
								        <tr valign="top">
								        <th scope="row">Enable reCaptcha For User Registration</th>
										<td> <select name="kv_recaptcha_enable_signup" >
											<option value="Yes" <?php if(get_option('kv_recaptcha_enable_signup') == 'Yes') echo 'selected' ; ?>> Yes </option>
											<option value="No" <?php if(get_option('kv_recaptcha_enable_signup') == 'No') echo 'selected' ; ?>> No </option>
										</select> </td>
								        </tr>
								        
										<tr valign="top">
								        <th scope="row">Private Key</th>
								        <td>
										<input type="text" name="kv_recaptcha_privatekey" size="60px" value="<?php echo get_option('kv_recaptcha_public_key'); ?>" >  </td>
										</tr>	

										<tr valign="top">
								        <th scope="row">Public Key</th>
								        <td>
										<input type="text" name="kv_recaptcha_public_key" size="60px" value="<?php echo get_option('kv_recaptcha_privatekey'); ?>" >  </td>
										</tr>
										
										<tr valign="top">
								        <th scope="row">Default Post Status </th>
								        <td><select name="kv_recaptcha_theme" >
											<option value="white" <?php if(get_option('kv_recaptcha_theme') == 'white') echo 'selected' ; ?>> White </option>
											<option value="red" <?php if(get_option('kv_recaptcha_theme') == 'red') echo 'selected' ; ?>> Red </option>
											<option value="blackglass" <?php if(get_option('kv_recaptcha_theme') == 'blackglass') echo 'selected' ; ?> > Black Glass </option>
											<option value="clean" <?php if(get_option('kv_recaptcha_theme') == 'clean') echo 'selected' ; ?> > Clean</option>
										</select>
										</td>
								        </tr>
								    </table>								    
								    <?php submit_button(); ?>
								</form>
							</div> 
						</div> 
					</div>
				</div> 
			</div>
		</div> 
</div> <!-- /wrap -->
<?php
/*$kv_recaptcha_public_key = 	get_option('kv_recaptcha_public_key');
	$kv_recaptcha_privatekey = get_option('kv_recaptcha_privatekey');
	$kv_recaptcha_theme = get_option('kv_recaptcha_theme'); 
	$kv_recaptcha_enable_signup = get_option('kv_recaptcha_enable_signup'); 
	
	if(empty($kv_recaptcha_public_key){ 
		add_option('kv_recaptcha_public_key','');
	}
	if(empty($kv_recaptcha_privatekey){ 
		add_option('kv_recaptcha_privatekey','');
	}
	if(empty($kv_recaptcha_theme){ 
		add_option('kv_recaptcha_theme','white');
	}
	/*if(empty(get_option('kv_recaptcha_enable_comments')){ 
		add_option('kv_recaptcha_enable_comments' , true);
	}
	if(empty($kv_recaptcha_enable_signup){ 
		add_option('kv_recaptcha_enable_signup' , true);
	}
		
		
		*/
}

?>