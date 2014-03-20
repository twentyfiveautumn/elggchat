<?php 
	/**
	* ElggChat - native elgg instant messenger
	* 
	* Nice display of an User for display in Friendspicker and Chat Members
	* 
	* @package elggchat
	* @author twentyfiveautumn.com
	* @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com.com/
	* @version 0.4
	*/
	
$page_owner = elgg_get_logged_in_user_entity();
// $relationship = $vars['users']; -- we'll use this once we start dealing with chat groups other than friends

$options = array(
	'relationship' => 'friend',
	'relationship_guid' => $page_owner->guid,
	'inverse_relationship' => FALSE,
	'type' => 'user',
	'full_view' => FALSE
);
$chat_users = elgg_get_entities_from_relationship($options);

foreach($chat_users as $chat_user){

	// make sure they have chat turned on
	if(elgg_get_plugin_user_setting("enableChat", $chat_user->guid,  "elggchat") == 'no'){ return null;}

	$diff = time() - $chat_user->last_action;
	$inactive = (int) elgg_get_plugin_setting("onlinestatus_inactive", "elggchat");
	$active   = (int) elgg_get_plugin_setting("onlinestatus_active", "elggchat");
	$title = sprintf(elgg_echo("elggchat:session:onlinestatus"), elgg_get_friendly_time($chat_user->last_action));
	
	if($diff <= $active){
		$onlineStatus = '<img src="'.$CONFIG->url.'mod/elggchat/_graphics/green.png" alt="'.$chat_user->name.'" class="chat_status" title="'.$title.'" data-toggle="tooltip" data-placement="bottom"/>';
	}elseif($diff <= $inactive){
		$onlineStatus = '<img src="'.$CONFIG->url.'mod/elggchat/_graphics/yellow.png" alt="'.$chat_user->name.'" class="chat_status" title="'.$title.'" data-toggle="tooltip" data-placement="bottom"/>';
	}else{
		$onlineStatus = '<img src="'.$CONFIG->url.'mod/elggchat/_graphics/red.png" alt="'.$chat_user->name.'" class="chat_status" title="'.$title.'" data-toggle="tooltip" data-placement="bottom"/>';
	}
	
//	end get the online status

$image = $chat_user->getIconURL('tiny');
$image = '<img src="'.$image.'" alt="'.$chat_user->name.'"/>';
$body = $chat_user->name;

$menu_item = array(
			'name' => $chat_user->name,			
			'text' => '<div>'.$image.$body.$onlineStatus.'</div>', 			
			'href' => '#',			
			'parent_name' => 'chat',
			'title' => $chat_user->name,
			'rel' => $chat_user->guid,
			);
			elgg_register_menu_item('topbar', $menu_item);

}	//	end foreach($chat_users as $chat_user)

return true;
