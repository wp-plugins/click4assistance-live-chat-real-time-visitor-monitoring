<?php
/*
Plugin Name: Click4Assistance Live Chat Software with real-time visitor monitoring
Plugin URI: http://wordpress.org/extend/plugins/Click4Assistance/
Description: Click4Assistance is the premier UK based Live Chat Software Provider. Allow visitors on your website to start a live chat, or you can proactively push an invitation asking if they need assistance, you can even monitor visitors in real-time while they browser your website. 1) Click the "Activate" link on the left of this description, 2) <a href="http://www.click4assistance.co.uk/Wordpress" target="_blank">Sign up for a Click4Assistance key</a>, and 3) Go to your Settings/Click4Assistance configuration page, and save your keys.
Version: 1.0
Author: Click4Assistance
Author URI: http://www.click4assistance.co.uk
License: GPLv2
*/

register_activation_hook(__FILE__, 'activate_Click4Assistance');
register_deactivation_hook(__FILE__, 'deactive_Click4Assistance');

function activate_Click4Assistance() {
	add_option('Click4Assistance_plugin_Account_GUID', '');
	add_option('Click4Assistance_plugin_Website_GUID', '');
	add_option('Click4Assistance_plugin_EmbeddedWorkflow_GUID', '');
	add_option('Click4Assistance_plugin_PopupWorkflow_GUID', '');
	add_option('Click4Assistance_plugin_EnableEmbeddedChatWindow', '');
	add_option('Click4Assistance_plugin_EnableTrackingAndProactiveInvitations', '');
}

function deactive_Click4Assistance() {
	delete_option('Click4Assistance_plugin_Account_GUID');
	delete_option('Click4Assistance_plugin_Website_GUID');
	delete_option('Click4Assistance_plugin_EmbeddedWorkflow_GUID');
	delete_option('Click4Assistance_plugin_PopupWorkflow_GUID');
	delete_option('Click4Assistance_plugin_EnableEmbeddedChatWindow');
	delete_option('Click4Assistance_plugin_EnableTrackingAndProactiveInvitations');
}


// Import the form and validation script
function Click4Assistance_admin() {
	include('Click4Assistance_import_admin.php');
}

// Add the menu item to a sub menu of Settings.		
add_action('admin_menu', 'Click4Assistance_admin_actions');
function Click4Assistance_admin_actions() {
	add_options_page("Click4Assistance", "Click4Assistance", 1, "Click4Assistance_Settings_Panel", "Click4Assistance_admin");
}

// Creating the shortcode function
add_shortcode("C4AChatButton", "C4AChatButtonRender");
function C4AChatButtonRender( $atts, $content = null ) {  
    #return '<div class="right text">"'.$content.'"</div>';

        $Click4Assistance_plugin_Account_GUID = get_option('Click4Assistance_plugin_Account_GUID');  
        $Click4Assistance_plugin_Website_GUID = get_option('Click4Assistance_plugin_Website_GUID');  
        $Click4Assistance_plugin_PopupWorkflow_GUID = get_option('Click4Assistance_plugin_PopupWorkflow_GUID');
	
	return '<!-- Click4Assistance Chat Button Script -->
			<a href="Javascript:var sURL=\'https://prod3ci.click4assistance.co.uk/Default.aspx?AccountGUID='.$Click4Assistance_plugin_Account_GUID.'&WebsiteGUID='.$Click4Assistance_plugin_Website_GUID.'&WorkflowGUID='.$Click4Assistance_plugin_PopupWorkflow_GUID.'&Origin=\'+ location.href + \'&Referrer=\' + document.referrer; var sTHID = (typeof C4A_TB == \'object\') ? \'&THID=\' + C4A_TB.getTHID() : \'&THID=\'; var x=window.open(sURL+sTHID,\'_blank\',\'menubar=no,location=no,resizable=no,scrollbars=auto,status=no\');">
			<img style="cursor:pointer;border:none;" src="https://prod3si.click4assistance.co.uk/Button/DynamBtn.aspx?AccGUID='.$Click4Assistance_plugin_Account_GUID.'&WSGUID='.$Click4Assistance_plugin_Website_GUID.'&WFGUID='.$Click4Assistance_plugin_PopupWorkflow_GUID.'" />
			</a>
			<!-- Click4Assistance Chat Button Script -->'  ;
}
	

// Add the tracking code to the footer of every page
add_action ('wp_footer', 'add_tracking_code_to_footer');
add_action ('wp_footer', 'add_embeddedchat_code_to_footer');

function add_tracking_code_to_footer() {


	// Check its enabled
	$Click4Assistance_plugin_EnableTrackingAndProactiveInvitations = get_option('Click4Assistance_plugin_EnableTrackingAndProactiveInvitations');
 	if ($Click4Assistance_plugin_EnableTrackingAndProactiveInvitations == "OFF")
		return;

	if (CheckConfiguration()==false) return;

	$Click4Assistance_plugin_Account_GUID = get_option('Click4Assistance_plugin_Account_GUID');  
	$Click4Assistance_plugin_Website_GUID = get_option('Click4Assistance_plugin_Website_GUID');  
	
	echo '<!-- Click4Assistance Tracking/Proactive Script -->
			<script type="text/javascript" defer="defer">
			var C4A_TB;
			function C4AJSJustLoaded(){
			C4A_TB = C4ATB();
			C4A_TB.setAccountGUID(\''.$Click4Assistance_plugin_Account_GUID.'\');
			C4A_TB.setWebsiteGUID(\''.$Click4Assistance_plugin_Website_GUID.'\');
			C4A_TB.setUseCookie(true);
			C4A_TB.Run();
			}
			</script>
			<script src="https://prod3si.click4assistance.co.uk/JS/TrackProactive.js" type="text/javascript" defer="defer"></script>
			<noscript>
			<img src="https://prod3si.click4assistance.co.uk/Tracking/PageHit_NoScript.aspx?AccountGUID='.$Click4Assistance_plugin_Account_GUID.'&WebsiteGUID='.$Click4Assistance_plugin_Website_GUID.'" />
			</noscript>
			<!-- Click4Assistance Tracking/Proactive Script -->';
	
}


function add_embeddedchat_code_to_footer() {

	// Check its enabled
	$Click4Assistance_plugin_EnableEmbeddedChatWindow = get_option('Click4Assistance_plugin_EnableEmbeddedChatWindow');
 	if ($Click4Assistance_plugin_EnableEmbeddedChatWindow == "OFF")
		return;
	$Click4Assistance_plugin_Account_GUID = get_option('Click4Assistance_plugin_Account_GUID');  
	$Click4Assistance_plugin_Website_GUID = get_option('Click4Assistance_plugin_Website_GUID');  
	$Click4Assistance_plugin_EmbeddedWorkflow_GUID = get_option('Click4Assistance_plugin_EmbeddedWorkflow_GUID');  
	$Click4Assistance_plugin_PopupWorkflow_GUID = get_option('Click4Assistance_plugin_PopupWorkflow_GUID'); 

	if (CheckConfiguration()==false) return;

	echo '<!-- Click4Assistance Embedded Chat Button Script -->
		<script type="text/javascript"> 
		var head = document.getElementsByTagName("head")[0]; 
		var srcC4AW = document.createElement("script"); 
		srcC4AW.type = "text/javascript"; 
		srcC4AW.charset = "utf-8"; 
		srcC4AW.id = "srcC4AWidget"; 
		srcC4AW.defer = true; 
		srcC4AW.async = true; 
		srcC4AW.src = "https://prod3si.click4assistance.co.uk/JS/ChatWidget.js"; 
		if (head) {head.appendChild(srcC4AW);} 

		function C4AWJSLoaded() { 
			oC4AW_Widget = new oC4AW_Widget(); 
			oC4AW_Widget.setAccGUID("'.$Click4Assistance_plugin_Account_GUID.'"); 
			oC4AW_Widget.setWSGUID("'.$Click4Assistance_plugin_Website_GUID.'"); 
			oC4AW_Widget.setWFGUID("'.$Click4Assistance_plugin_EmbeddedWorkflow_GUID.'"); 
			oC4AW_Widget.setPopupWindowWFGUID("'.$Click4Assistance_plugin_PopupWorkflow_GUID.'"); 
			oC4AW_Widget.setDockPosition("BOTTOM"); 
			oC4AW_Widget.setBtnStyle("position:fixed; border:none; bottom:0em; right:1em;"); 
			oC4AW_Widget.setIdentity("Embedded Chat"); 
			oC4AW_Widget.Initilize(); 
		} 
		</script> 
		<!-- Click4Assistance Embedded Chat Button Script -->';

}
	


// Create the widget
add_action( 'widgets_init', 'click4assistance_widget' );
function click4assistance_widget() {
	register_widget( 'Click4Assistance_Widget' );
}

class Click4Assistance_Widget extends WP_Widget {

	function Click4Assistance_Widget() {
		
		$widget_ops = array( 'classname' => 'Click4Assistance_Widget', 'description' => __('A widget that displays the Click4Assistance chat button ', 'click4assistance') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'click4assistance-widget' );
		
		$this->WP_Widget( 'click4assistance-widget', __('Click4Assistance Widget', 'click4assistance'), $widget_ops, $control_ops );
		
	}
function widget( $args, $instance ) {
	extract( $args );
	echo $before_widget;

	if (CheckConfiguration ()==false) return;

	// Get the guids and update the chat script
        $Click4Assistance_plugin_Account_GUID = get_option('Click4Assistance_plugin_Account_GUID');  
        $Click4Assistance_plugin_Website_GUID = get_option('Click4Assistance_plugin_Website_GUID');  
        $Click4Assistance_plugin_PopupWorkflow_GUID = get_option('Click4Assistance_plugin_PopupWorkflow_GUID');
	
	echo '<!-- Click4Assistance Chat Button Script -->
			<a href="Javascript:var sURL=\'https://prod3ci.click4assistance.co.uk/Default.aspx?AccountGUID='.$Click4Assistance_plugin_Account_GUID.'&WebsiteGUID='.$Click4Assistance_plugin_Website_GUID.'&WorkflowGUID='.$Click4Assistance_plugin_PopupWorkflow_GUID.'&Origin=\'+ location.href + \'&Referrer=\' + document.referrer; var sTHID = (typeof C4A_TB == \'object\') ? \'&THID=\' + C4A_TB.getTHID() : \'&THID=\'; var x=window.open(sURL+sTHID,\'_blank\',\'menubar=no,location=no,resizable=no,scrollbars=auto,status=no\');">
			<img style="cursor:pointer;border:none;" src="https://prod3si.click4assistance.co.uk/Button/DynamBtn.aspx?AccGUID='.$Click4Assistance_plugin_Account_GUID.'&WSGUID='.$Click4Assistance_plugin_Website_GUID.'&WFGUID='.$Click4Assistance_plugin_PopupWorkflow_GUID.'" />
			</a>
			<!-- Click4Assistance Chat Button Script -->'  ;


		
	echo $after_widget;
	}

	//Update the widget 
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		#No updates are done here

		return $instance;
	}

	
	function form( $instance ) {

		//Warn user the settings are inputted from control page
		echo "Please make sure you have updated your settings in Settings > Click4Assistance";
		

	}
	
	
}

function CheckConfiguration ()
{
	$Click4Assistance_plugin_Account_GUID = get_option('Click4Assistance_plugin_Account_GUID');  
	$Click4Assistance_plugin_Website_GUID = get_option('Click4Assistance_plugin_Website_GUID');  
	$Click4Assistance_plugin_EmbeddedWorkflow_GUID = get_option('Click4Assistance_plugin_EmbeddedWorkflow_GUID');  
	$Click4Assistance_plugin_PopupWorkflow_GUID = get_option('Click4Assistance_plugin_PopupWorkflow_GUID'); 

	if ($Click4Assistance_plugin_Account_GUID == "" || $Click4Assistance_plugin_Website_GUID == "" || $Click4Assistance_plugin_EmbeddedWorkflow_GUID =="" || $Click4Assistance_plugin_PopupWorkflow_GUID == "")
	{
		echo '<div style="position:fixed;bottom:0em;right:1em;z-index:99999; width:350px; height:250px; background-color:#e10019; padding:8px;">
		<div style="color:#e10019; background-color:#fff; border:solid 4px #e10019; font-size:14px; font-family:Tahoma; padding:4px; font-weight:bold; text-align:center;">Configure your Click4Assistance chat button</div>
		<div style="color:#fff; background-color:#e10019; border:solid 4px #e10019; font-size:14px; font-family:Tahoma; padding:4px; text-align:center;">Enter your Click4Assistance details within your Wordpress Dashboard under  &#34;Settings / Click4Assistance&#34;.<br><br>If you haven’t registered or need help, visit <a href="http://www.click4assistance.co.uk/WordPress" target="_blank" style="color:#fff; text-decoration:underline;">www.click4assistance.co.uk/WordPress</a></div>

		</div>';
		return false;	
	}
	else {
		return true;
	}
}

	
?>
