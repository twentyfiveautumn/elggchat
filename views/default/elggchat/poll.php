<?php 
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Action to get all the information to form the ElggChat Toolbar
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

if($user = elgg_get_logged_in_user_entity()){

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
	$result = array();

	if($chat_sessions_count > 0){
		// Generate sessions
		krsort($chat_sessions);
		$result["sessions"] = array();
		
/*****	feeling ok about the code above here	*****/		

		foreach($chat_sessions as $session){
		
	//	$session->delete();
		
			$result["sessions"][$session->guid] = array();
				
			// List all the Members of the chat session
			$members = $session->getEntitiesFromRelationship(ELGGCHAT_MEMBER);	//	for whatever reason this appears to work ok??

					if(is_array($members) && count($members) > 1){		//	me and somebody else
					
					$result["sessions"][$session->guid]["members"] = array();
					
					$firstMember = true;
					
					foreach($members as $member){
						if($member->guid != $user->guid){
							if($firstMember){
								if(count($members) > 2){
									$result["sessions"][$session->guid]["name"] = $member->name . " [" . (count($members) - 2) . "]";
								} else {
									$result["sessions"][$session->guid]["name"] = $member->name;
								}
								$firstMember = false;
							}
							$result["sessions"][$session->guid]["members"][] = elgg_view("elggchat/user", array("chatuser" => $member));
						}
					}
				} else {	//	just me
					$result["sessions"][$session->guid]["name"] = sprintf(elgg_echo("elggchat:session:name:default"), $session->guid);
				}
				// List all the messages in the session
				
				$messages = $session->getAnnotations(ELGGCHAT_MESSAGE);
				$message_count = count($messages);
				
				$result["sessions"][$session->guid]["message_count"] = $message_count;
				
				if($message_count > 0){
					$result["sessions"][$session->guid]["messages"] = array();
					
					foreach($messages as $msg){
					
				//	$msgResult = elgg_view("elggchat/message", array("message" => $msg, "message_owner" => get_user($msg->owner_guid), "offset" => $msg->id)); 
					
				//		$result["sessions"][$session->guid]["messages"][$msg->id] = elgg_view("elggchat/message", array("message" => $msg, "message_owner" => get_user($msg->owner_guid), "offset" => $msg->id)); 
		$message_owner = get_user($msg->owner_guid);			
						
$result["sessions"][$session->guid]["messages"][$msg->id]["icon"] = "<a href='" . $message_owner->getURL() . "'><img class='messageIcon' alt='" . $message_owner->name . "' src='". $message_owner->getIconURL('tiny') . "'></a>";

$result["sessions"][$session->guid]["messages"][$msg->id]["messageName"] = $user->name;

$result["sessions"][$session->guid]["messages"][$msg->id]["message"] = elgg_view("elggchat/message", array("message" => $msg, "message_owner" => get_user($msg->owner_guid), "offset" => $msg->id)); 


						
					}
					
				}	//	end if($msg_count > 0
				
		}		//	end foreach($chat_sessions as $session
		
	}	//		end if($chat_sessions_count > 0
	
	// Add friends information
	$friends = $user->getEntitiesFromRelationship("friend");
	if(is_array($friends) && count($friends) > 0){
		if(count($friends) == 50){
			$friends_count = $user->countEntitiesFromRelationship("friend");
			$friends = $user->getEntitiesFromRelationship("friend", false, $friends_count);
		}
		$result["friends"] = array();
		$result["friends"]["offline"] = array();
		$result["friends"]["online"] = array();
		
		$inactive = (int) elgg_get_plugin_setting("onlinestatus_inactive", "elggchat");
		$time = time();
		foreach($friends as $friend){
			if($time - $friend->last_action <= $inactive){
				$result["friends"]["online"][] = elgg_view("elggchat/user", array("chatuser" => $friend));
			} else {
				$result["friends"]["offline"][] = elgg_view("elggchat/user", array("chatuser" => $friend));
			}
		}
	}
	
	// Prepare to send nice JSON
	header("Content-Type: application/json; charset=UTF-8");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	
	echo(json_encode($result)); die();

}		//	end if($user = elgg_get_logged_in_user_entity
exit();
?>