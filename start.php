<?php
	/**
	* ElggChat - native elgg instant messenger
	* 
	* Main initialization file
	* 
	* @package elggchat
	* @author twentyfiveautumn.com
	* @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com.com/
	* @version 0.4
	*/
		
	define("ELGGCHAT_MEMBER", "elggchat_member");
	define("ELGGCHAT_SESSION_SUBTYPE", "elggchat_session");
	define("ELGGCHAT_SYSTEM_MESSAGE", "elggchat_system_message");
	define("ELGGCHAT_MESSAGE", "elggchat_message");	
	
	function elggchat_init() {
	
		if(!elgg_is_logged_in() or elgg_get_plugin_user_setting("enableChat", "elggchat") == 'no') {
		return null;
		}
	
		//sound js 
		$chatsound_js = 'mod/elggchat/js/sound/jquery.sound.js';
		elgg_register_js('chatsound_js', $chatsound_js, 'footer' );
		elgg_load_js('chatsound_js');
		
		if(elgg_is_logged_in()){
		//	elgg_extend_view('page/elements/header', 'elggchat/session_monitor');
			elgg_extend_view('page/elements/footer', 'elggchat/session_monitor');
		//	elgg_extend_view('css/elgg', 'elggchat/css');
			elgg_extend_view('js/elgg', 'elggchat/js');
		
		//	because we need it to load after bootstrap
		
			$elggchat_css = 'mod/elggchat/js/elggchat.css';
			elgg_register_css('elggchat_css', $elggchat_css );
	
			if($get_context != 'admin'){
				elgg_load_css('elggchat_css');
			}
		}
		
		//	start building the chat menu
		
		elgg_register_menu_item('topbar', array(
				'name' => 'chat',
				'priority' => 1100,
				'text' => 'Chat <b class="caret"></b>',
				'href' => '#',
				'title' => $tooltip,
				'data-toggle' => "dropdown",
				'link_class' => "dropdown-toggle",
				'item_class' => 'dropdown',
			));
			
		//	pass $vars because we may want a group of users other than friends
		$vars = array('users' => 'friend');
		elgg_view('elggchat/chat_menu', $vars, $bypass = false, $ignored = false, $viewtype = 'default');
			
				
		//	end building the chat menu
		
		
		
    }	//	end elggchat_init()
	
	// Cron Actions
	function elggchat_session_cleanup($hook, $entity_type, $returnvalue, $params){
		$context = elgg_get_context();
		elgg_set_context("elggchat_cron_context");
		
		$session_count = elgg_get_entities("object", ELGGCHAT_SESSION_SUBTYPE, 0, "", 0, 0, true);
		$sessions = elgg_get_entities("object", ELGGCHAT_SESSION_SUBTYPE, 0, "", $session_count);
		
		foreach($sessions as $session){
			$member_count = $session->countEntitiesFromRelationship(ELGGCHAT_MEMBER);
			
			if($member_count > 0){
				$max_age = (int) elgg_get_plugin_setting("maxSessionAge");
				$age = time() - $session->time_updated;
				
				if($age > $max_age){
					$session->delete();
				}
			} else {
				$session->delete();
			}
		}
		elgg_set_context($context);
	}
	
	function elggchat_permissions_check($hook_name, $entity_type, $return_value, $parameters) {
		$result = $return_value;
		
		if(elgg_get_context() == "elggchat_cron_context"){
			$result = true;
		}
		
		return $result;
	}
	
	function elggchat_logout_handler($event, $object_type, $object){
	
		if(!empty($object) && $object instanceof ElggUser){
	
		$chat_sessions = elgg_get_entities_from_relationship(array(
		'relationship' => 'elggchat_member',
		'relationship_guid' => $user->guid,
		'inverse_relationship' => TRUE,
		'types' => 'object',
		'subtypes' => ELGGCHAT_SESSION_SUBTYPE,
		'limit' => $limit,
		'offset' => $offset
		));
		$chat_sessions_count = count($chat_sessions);
	
			if($chat_sessions_count > 0){
			
				foreach($chat_sessions as $session){
					remove_entity_relationship($session->guid, ELGGCHAT_MEMBER, $object->guid);
					$session->annotate(ELGGCHAT_SYSTEM_MESSAGE, sprintf(elgg_echo('elggchat:action:leave'), $object->name), ACCESS_LOGGED_IN, $object->guid);	//	@todo this does not work...
					// Clean up
					if($session->countEntitiesFromRelationship(ELGGCHAT_MEMBER) == 0){
						// No more members
						$session->delete();
					}elseif($session->countAnnotations(ELGGCHAT_MESSAGE) == 0 && !check_entity_relationship($session->guid, ELGGCHAT_MEMBER, $session->owner_guid)){
						// Owner left without leaving a real message
						$session->delete();
					}
				}	//	end	foreach($sessions as $session)
				
			}	//	end if($chat_sessions_count > 0)
		}	//	end if(!empty($object) && $object instanceof ElggUser)
		
		return true;
	}	//	end function elggchat_logout_handler
	
	elgg_register_event_handler('init', 'system', 'elggchat_init');
	
	// Permission check overrule
	elgg_register_plugin_hook_handler('permissions_check', 'all', 'elggchat_permissions_check');
	
	// Register Cron Jobs
	elgg_register_plugin_hook_handler('cron', 'hourly', 'elggchat_session_cleanup');
	
	// Extend avatar hover menu
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'elggchat_user_hover_menu');
	
	// Logout event handler
	elgg_register_event_handler('logout', 'user', 'elggchat_logout_handler');
	
	elgg_register_page_handler('elggchat', 'elggchat_page_handler');
	
	function elggchat_page_handler() {
		echo elgg_view('elggchat/index');
	}
	
	// ajax views
	elgg_register_ajax_view('elggchat/list');
	elgg_register_ajax_view('elggchat/create');
	elgg_register_ajax_view('elggchat/post_message');
	elgg_register_ajax_view('elggchat/poll');
	elgg_register_ajax_view('elggchat/invite');
	elgg_register_ajax_view('elggchat/leave');
	elgg_register_ajax_view('elggchat/get_smiley');
	
/*****	Add to the user hover menu	*****/

function elggchat_user_hover_menu($hook, $type, $return, $params) {
	$user = $params['entity'];

	if (elgg_is_logged_in() && elgg_get_logged_in_user_guid() != $user->guid) {
		$url = "javascript:startSession(".$user->guid.")";
	//	$url = "messages/compose?send_to={$user->guid}";
		$item = new ElggMenuItem('invite', elgg_echo('elggchat:chat:profile:invite'), $url);
		$item->setSection('action');
		$return[] = $item;
	}

	return $return;
}
