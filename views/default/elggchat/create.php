<?php
	/**
	* ElggChat - native elgg instant messenger
	* 
	* Action to create a chat session with specified user
	* 
	* @package elggchat
	* @author twentyfiveautumn.com
	* @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com.com/
	* @version 0.5
	*/
	
	gatekeeper();
	
	$inviteId = (int) get_input("friendGUID", NULL, TRUE);
	
	if(($invite_user = get_user($inviteId)) && $inviteId != elgg_get_logged_in_user_guid()){
		$user = elgg_get_logged_in_user_entity();
		
		$session = new ElggObject();
		$session->subtype = ELGGCHAT_SESSION_SUBTYPE;
		$session->access_id = ACCESS_LOGGED_IN;
		$session->save();
		$session->addRelationship($user->guid, ELGGCHAT_MEMBER);
		$session->addRelationship($invite_user->guid, ELGGCHAT_MEMBER);
	//	echo $session->guid; die();
		
		$return = new stdClass();
		$return->id = $session->guid;
		$return->friend->guid = $invite_user->guid;
		$return->friend->name = $invite_user->name;
		
		echo json_encode($return); die();
	}
