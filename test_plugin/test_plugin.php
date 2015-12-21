<?php
/*include("ajax/ajax.php");*/
/**
  * Plugin Name: Add Social Link
  * Plugin URI: http://your-domain.com
  * Description: This plugin for add social plugin link
  * Version: 1.0.0
  * Author: You
  * Author URI: http://your-domain.com
  */
  
  
 /* define the files start*/
 if ( !defined( 'BS_PLUGIN_BASENAME' ) ) define( 'BS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
 if ( !defined( 'BS_PLUGIN_NAME' ) ) define( 'BS_PLUGIN_NAME', trim( dirname( BS_PLUGIN_BASENAME ), '/' ) );
 if ( !defined( 'BS_PLUGIN_URL' ) )	define( 'BS_PLUGIN_URL', WP_PLUGIN_URL . '/' . BS_PLUGIN_NAME ); 
  /* define the files end*/

/**
 * Proper way to enqueue scripts and styles
 */
 add_action('init', 'register_script');

function register_script(){

	
	wp_register_script( 'script-name', BS_PLUGIN_URL.'/js/jquery-1.10.2.min.js' );
	wp_register_script( 'test-script-name', BS_PLUGIN_URL.'/js/test.js' );
	
	wp_register_script( 'ace_code_highlighter_js', BS_PLUGIN_URL.'/js/ace.js' );
	wp_register_script( 'ace_mode_js', BS_PLUGIN_URL.'/js/mode-css.js' );
	wp_register_script( 'custom_css_js', BS_PLUGIN_URL.'/js/custom-css.js' );

}



add_action('admin_enqueue_scripts', 'enqueue_style');

function enqueue_style(){
	wp_enqueue_script( 'script-name' );
	wp_enqueue_script( 'test-script-name' );
	
	wp_enqueue_script( 'ace_code_highlighter_js' );
	wp_enqueue_script( 'ace_mode_js' );
	wp_enqueue_script( 'custom_css_js' );
}




add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' ); 

function theme_options_init(){
 register_setting( 'sample_options', 'sample_theme_options');
 register_setting( 'custom_css', 'custom_css',  'custom_css_validation');
	} 




function theme_options_add_page() {
 add_theme_page( __( 'Theme Options', 'sampletheme' ), __( 'Theme Options', 'sampletheme' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
     /* add_theme_page( 'Custom CSS',  __( 'Custom CSS' ), 'edit_theme_options', 'custom_css_admin_page_content', 'theme_options_do_page' );*/

} 
?>
<style>
.buttons {
margin-top: 20px;
}
</style>
<?php
function theme_options_do_page() 
	{
	
	?>
	<div class="buttons"><input type="button" id="social_btn" value="Social Links"/><input type="button" id="favicon_btn" value="FavIcon"/><input type="button" id="custom_css_btn" value="Custom Css"/></div>
	<div class="social_tab" <?php if(isset($_POST['fav_submit'])||isset($_POST['custom_css'])){ ?>  style="display:none;"<?php }elseif(isset($_POST['req_submit'])){ ?> style="display:block;" <?php } ?> >
	<?php
		
		if ( isset($_POST['update_themeoptions']) == 'true' ) { themeoptions_update(); }
?>	
	<div class="wrap">
	<div id="social_options">
		<h2>Social Icon Links</h2>
		<form method="post" action="" name="social_form" id="social_form" >
			<input type="hidden" name="update_themeoptions" value="true" />
			<label>Facebook URL</label><br />
			<input type="text" name="facebook_url" size="40" id="fb" value="<?php echo get_option('facebook_url'); ?>"/><br />
			<label>Twitter URL</label><br />
			<input type="text" name="twitter_url" size="40" id="tw"  value="<?php echo get_option('twitter_url'); ?>"/><br />
			<label>LinkedIn URL</label><br />
			<input type="text" name="linked_url" size="40" id="in"  value="<?php echo get_option('linked_url'); ?>"/><br />
			<label>Plannen URL</label><br />
			<input type="text" name="plannen_url" size="40" id="pl"  value="<?php echo get_option('plannen_url'); ?>"/><br />
			<input id="btn" type="submit" value="Save" name="req_submit" />	
		</form>
	</div>
</div>
	<style>
	#social_options{
		width: 50%;
		}
	#social_options label {
    font-size: 15px;
    font-weight: bold;
    padding: 0 0 12px;
	}
	#social_options input {
    margin: 0 0 25px;
	}
	#social_options form {
    margin-left: 25px;
	margin-top:35px;
	}	
	#social_options #btn {
    cursor: pointer;
    width: 100px;
	}
	
	</style>	
	
	</div><!--social_tab-->
	
	<div class="favicon_tab" <?php if(isset($_POST['fav_submit'])){ ?> style="display:block;"<?php
	}else { ?> style="display:none;"<?php } ?>>
	<?php
			if (  isset($_POST['update_themeoptions1']) == 'true' ) {  
		
$upload = wp_upload_bits($_FILES["favicon_image_url"]["name"], null, file_get_contents($_FILES["favicon_image_url"]["tmp_name"]));
 $upload_path = wp_upload_dir();
 
$path=$upload_path["url"];
 
$name=$_FILES["favicon_image_url"]["name"];

$image_url=$path."/".$name;

themeoptions_update1( $image_url); 
		}
?>	
	<div class="wrap">
	<div id="social_options">
		<h2>Fav Icon</h2>
		<form method="post" action="" name="social_form" id="fav_icon_form" enctype="multipart/form-data" >
			<input type="hidden" name="update_themeoptions1" value="true" />
			<label>Fav Icon</label><br />
			<input type="file" name="favicon_image_url" id="favicon_img" size="40" id="fb" value="<?php echo get_option('favicon_image_url');?>"  accept="image/*"  onchange="showMyImage(this)"  /><br />
			<input id="btn1" type="submit" value="Save" name="fav_submit" />	
			 <br/>
<?php
	if(get_option('favicon_image_url')) { ?>
	<img id="thumbnil"  src="<?php echo get_option('favicon_image_url');?>" alt="image" height="100" width="100" />
	<?php
	}else { ?>
	<img id="thumbnil" style="width:20%; margin-top:10px;display:none;"  src="" alt="image"  height="100" width="100"/>
	<?php }
	
	
	 ?>
		</form>
	</div>
</div>

<?php 

	
	?>
	
	</div><!--favicon_tab-->
	
	<div class="custom_css_tab" <?php if(isset($_POST['custom_css'])){ ?> style="display:block;"<?php
	}else { ?> style="display:none;"<?php } ?>>
	
	
	<?php
	
	/* custom css  start*/

	/*function custom_css_admin_page_content() {
	?>*/
	?>
<style>
textarea {
resize: none;
}

div.msg {
border-left: 4px solid #7ad03a;
padding: 1px 12px;
background-color: #fff;
-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

}
.media-upload-form div.error, .wrap div.error, .wrap div.msg {
margin: 5px 0 15px;
}
p {
font-size: 13px;
line-height: 1.5;
margin: 1em 0;
}
</style>
	<?php
	if(isset($_POST['custom_css'])){
	themeoptions_update2();
	/*echo "available	";*/
	}
    // The default message that will appear
    $custom_css_default = __( '/*
Welcome to the Custom CSS editor!
 
Please add all your custom CSS here and avoid modifying the core theme files, since that\'ll make upgrading the theme problematic. Your custom CSS will be loaded after the theme\'s stylesheets, which means that your rules will take precedence. Just add your CSS here for what you want to change, you don\'t need to copy all the theme\'s style.css content.
*/' );
    $custom_css = get_option( 'custom_css', $custom_css_default );
    ?>
    <div class="wrap">
        
 
        <form id="custom_css_form" method="post" action="" style="margin-top: 15px;">
		<?php if(isset($_POST['custom_css'])){ ?><div id="message" class="msg"><p><strong> Custom CSS Updated.
		</strong></p></div>
		<?php }?>
		
 <!--<div id="icon-themes" class="icon32"></div>-->
        <h2><?php _e( 'Custom CSS' ); ?></h2>
	
		
            <?php //settings_fields( 'custom_css' ); ?>
 
            <textarea id="custom_css_textarea" name="custom_css"  style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"><?php echo $custom_css; ?></textarea>
            <p><input type="submit" name="custom_css_sub" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" /></p>
        </form>
    </div>
<?php
/*}*/


?>
	</div>
<?php 
}
 function themeoptions_update()
 	{ 
	update_option('facebook_url',$_POST['facebook_url']);	
	update_option('twitter_url', $_POST['twitter_url']);
	update_option('linked_url', $_POST['linked_url']);
	update_option('plannen_url', $_POST['plannen_url']);
	
	}
	 function themeoptions_update1($image_url){
		update_option('favicon_image_url',$image_url);	
	 }
	 
	 function themeoptions_update2(){
		update_option('custom_css',$_POST['custom_css']);	
	 }

add_shortcode('social_icons', 'theme_options_do_page');
?>

<?php

function custom_css_validation( $input ) {
    if ( ! empty( $input['custom_css'] ) )
        $input['custom_css'] = trim( $input['custom_css'] );
    return $input;
}

add_action( 'wp_head', 'display_custom_css' );
 
function display_custom_css() {
    ?>
<?php
$custom_css = get_option( 'custom_css' );
if ( ! empty( $custom_css ) ) { ?>
<style type="text/css">
    <?php
    echo '/* Custom CSS */' . "\n";
    echo $custom_css . "\n";
    ?>
</style>
    <?php
}

}
	
	
	
