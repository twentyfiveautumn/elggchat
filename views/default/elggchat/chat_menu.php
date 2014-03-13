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
	
$page_owner = elgg_get_page_owner_entity();
$relationship = $vars['users'];

$options = array(
	'relationship' => 'friend',
	'relationship_guid' => $page_owner->guid,
	'inverse_relationship' => FALSE,
	'type' => 'user',
	'full_view' => FALSE
);
$chat_users = elgg_get_entities_from_relationship($options);

foreach($chat_users as $chat_user){

// @todo make sure they are not the page owner and they have chat turned on

//	get the online status

	$diff = time() - $user->last_action;
	$inactive = (int) elgg_get_plugin_setting("onlinestatus_inactive", "elggchat");
	$active   = (int) elgg_get_plugin_setting("onlinestatus_active", "elggchat");
	$title = sprintf(elgg_echo("elggchat:session:onlinestatus"), elgg_get_friendly_time($chat_user->last_action));
	
	if($diff <= $active){
		$onlineStatus = '<img src="'.$CONFIG->url.'mod/elggchat/_graphics/green.png" alt="'.$chat_user->username.'" class="chat_status" title="'.$title.'"/>';
	}elseif($diff <= $inactive){
		$onlineStatus = '<img src="'.$CONFIG->url.'mod/elggchat/_graphics/yellow.png" alt="'.$chat_user->username.'" class="chat_status" title="'.$title.'"/>';
	}else{
		$onlineStatus = '<img src="'.$CONFIG->url.'mod/elggchat/_graphics/red.png" alt="'.$chat_user->username.'" class="chat_status" title="'.$title.'"/>';
	}
	
//	end get the online status

$image = $chat_user->getIconURL('tiny');
$image = '<img src="'.$image.'" alt="'.$chat_user->username.'"/>';
$body = $chat_user->username;

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
