<?php   

function CheckGUID($guid, $errMessage) {
	if ($guid=='') {return true;}
	$guid= strtoupper($guid);

	if (preg_match('/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/', $guid)) {
  		return true;} 
	else {
		echo '<script type="text/javascript">alert("'.$errMessage.'");</script>';
		return false;
	}
}



    if($_POST['Click4Assistance_plugin_hidden'] == 'Y') {  

	//Form data sent  
	$Click4Assistance_plugin_Account_GUID = $_POST['Click4Assistance_plugin_Account_GUID'];  
	$Click4Assistance_plugin_Website_GUID = $_POST['Click4Assistance_plugin_Website_GUID'];  
	$Click4Assistance_plugin_Workflow_GUID = $_POST['Click4Assistance_plugin_Workflow_GUID'];  
         $Click4Assistance_plugin_EmbeddedWorkflow_GUID = $_POST['Click4Assistance_plugin_EmbeddedWorkflow_GUID'];  
	$Click4Assistance_plugin_PopupWorkflow_GUID = $_POST['Click4Assistance_plugin_PopupWorkflow_GUID'];  
	
	$Click4Assistance_plugin_EnableEmbeddedChatWindow = "OFF";
	if (isset($_POST['Click4Assistance_plugin_EnableEmbeddedChatWindow'])) {
		$Click4Assistance_plugin_EnableEmbeddedChatWindow = "ON";
	}

	$Click4Assistance_plugin_EnableTrackingAndProactiveInvitations = "OFF";
	if (isset($_POST['Click4Assistance_plugin_EnableTrackingAndProactiveInvitations'])) {
		$Click4Assistance_plugin_EnableTrackingAndProactiveInvitations = "ON";
	}

	// Validate GUIDs & Update data
	if (CheckGUID($Click4Assistance_plugin_Account_GUID,'Invalid Account GUID' ) == true)
		update_option('Click4Assistance_plugin_Account_GUID', $Click4Assistance_plugin_Account_GUID);  
         if (CheckGUID($Click4Assistance_plugin_Website_GUID,'Invalid Website GUID' ) == true)
	 	update_option('Click4Assistance_plugin_Website_GUID', $Click4Assistance_plugin_Website_GUID);  
	if (CheckGUID($Click4Assistance_plugin_PopupWorkflow_GUID,'Invalid Popup Workflow GUID' ) == true)
		update_option('Click4Assistance_plugin_PopupWorkflow_GUID', $Click4Assistance_plugin_PopupWorkflow_GUID);  

	if (CheckGUID($Click4Assistance_plugin_EmbeddedWorkflow_GUID,'Invalid Embedded Workflow GUID' ) == true)
		update_option('Click4Assistance_plugin_EmbeddedWorkflow_GUID', $Click4Assistance_plugin_EmbeddedWorkflow_GUID);  

	update_option('Click4Assistance_plugin_EnableEmbeddedChatWindow', $Click4Assistance_plugin_EnableEmbeddedChatWindow);  
	update_option('Click4Assistance_plugin_EnableTrackingAndProactiveInvitations', $Click4Assistance_plugin_EnableTrackingAndProactiveInvitations);  
		
    } else {  
	
	//Normal page display  
	$Click4Assistance_plugin_Account_GUID = get_option('Click4Assistance_plugin_Account_GUID');  
	$Click4Assistance_plugin_Website_GUID = get_option('Click4Assistance_plugin_Website_GUID');  
	$Click4Assistance_plugin_EmbeddedWorkflow_GUID = get_option('Click4Assistance_plugin_EmbeddedWorkflow_GUID');  
	$Click4Assistance_plugin_PopupWorkflow_GUID = get_option('Click4Assistance_plugin_PopupWorkflow_GUID'); 
	$Click4Assistance_plugin_EnableEmbeddedChatWindow  = get_option('Click4Assistance_plugin_EnableEmbeddedChatWindow');
	$Click4Assistance_plugin_EnableTrackingAndProactiveInvitations = get_option('Click4Assistance_plugin_EnableTrackingAndProactiveInvitations');
    }  
?>

<div class="wrap">  
   
    <?php screen_icon();?>

    <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  

	<input type="hidden" name="Click4Assistance_plugin_hidden" value="Y">
  	<h2>Click4Assistance Settings</h2>
 	<p>In order to activate your Click4Assistance Live Chat feature please enter the GUID details which you were provided during registration, they are also contained in your Click4Assistance welcome email. Please If you haven’t registered with Click4Assiatance or require help, visit <a href="http://www.click4assistance.co.uk/WordPress" target="_new">www.click4assistance.co.uk/WordPress</a></p>
<br>
<h4>General Settings</h4>
<table>
<tr>
<td style="width:250px;">Account GUID:</td>
<td><input type="text" name="Click4Assistance_plugin_Account_GUID" value="<?php echo $Click4Assistance_plugin_Account_GUID; ?>" size="45"></td>
<td><i>eg: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</i></td>
</tr>
<tr>
<td>Website GUID:</td>
<td><input type="text" name="Click4Assistance_plugin_Website_GUID" value="<?php echo $Click4Assistance_plugin_Website_GUID; ?>" size="45"></td>
<td><i>eg: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</i></td>
</tr>
<tr>
<td>Enable Embedded Chat Window:</td>
<td colspan="2"><input type="checkbox" name="Click4Assistance_plugin_EnableEmbeddedChatWindow" value="yes" <?php if ($Click4Assistance_plugin_EnableEmbeddedChatWindow == "" || $Click4Assistance_plugin_EnableEmbeddedChatWindow == "ON") echo "checked='checked'"; ?>><i>&nbsp;&nbsp;This provides a sticky chat button in the bottom right of every page with an embedded chat facility.</i></td>
</tr>
<td>Enable Tracking & Proactive Invitations:</td>
<td colspan="2"><input type="checkbox" name="Click4Assistance_plugin_EnableTrackingAndProactiveInvitations" value="yes" <?php if ($Click4Assistance_plugin_EnableTrackingAndProactiveInvitations == "" ||  $Click4Assistance_plugin_EnableTrackingAndProactiveInvitations == "ON") echo "checked='checked'"; ?>><i>&nbsp;&nbsp;This allows you to monitor visitors on your website in real-time and send them invitations to chat.</i></td>
</tr>
</table>

<hr /> 

<h4>Embedded Chat Window</h4>
<table>
<tr>
<td style="width:250px;">Workflow GUID (Embedded):</td>
<td><input type="text" name="Click4Assistance_plugin_EmbeddedWorkflow_GUID" value="<?php echo $Click4Assistance_plugin_EmbeddedWorkflow_GUID; ?>" size="45"></td>
<td><i>eg: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</i></td>
</tr>
</table>

<hr /> 

<h4>Popup Chat Window</h4>
<table>
<tr>
<td style="width:250px;">Workflow GUID (Popup):</td>
<td><input type="text" name="Click4Assistance_plugin_PopupWorkflow_GUID" value="<?php echo $Click4Assistance_plugin_PopupWorkflow_GUID; ?>" size="45"></td>
<td><i>eg: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx</i></td>
</tr>
</table>

<hr />  

        <p class="submit">  
        <input type="submit" name="Submit" class="button button-primary" value="<?php _e('Update Options', 'Click4Assistance_dom' ) ?>" />  
        </p>  
    </form>  
</div>
