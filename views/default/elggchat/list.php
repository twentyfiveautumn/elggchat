<?php
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* List all the sessions for debugging (admin only)
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

	admin_gatekeeper();
	$user = elgg_get_logged_in_user_entity();
	
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
	
	foreach($chat_sessions as $session){
		echo $session->getGUID() . ":<br />";
		echo "time_updated: " . $session->time_updated . "<br />";
		$members = elgg_get_entities_from_relationship(ELGGCHAT_MEMBER, $session->getGUID());
		
		foreach($members as $member){
			echo $member->name . "<br />";
			
			foreach ($member as $key => $value) {
		echo "Key: ".$key." Value: ".$value."<br />\n";
		}
			
			
		}
		echo "--------------------<br />";
		
		$messages = $session->getAnnotations(ELGGCHAT_MESSAGE);
		foreach($messages as $message){
			$user = get_entity($message->owner_guid);
			echo "<a href='" . $user->getURL() . "'target='_blank'><img alt='" . $user->name . "' src='". $user->getIconURL('tiny') . "'></a>";
			
			echo friendly_time ($message->time_created) . "<br/>";
			echo $message->value . "<br/>";
		}
	}
	
$invite_user = 925;

if($invite_user = 925 ){
		$user = elgg_get_logged_in_user_entity();
		
		$session = new ElggObject();
		$session->subtype = ELGGCHAT_SESSION_SUBTYPE;
		$session->access_id = ACCESS_LOGGED_IN;
		$session->save();
		
		$session->addRelationship($user->guid, ELGGCHAT_MEMBER);
		$session->addRelationship($invite_user->guid, ELGGCHAT_MEMBER);
		
	}
	exit();
