<?php
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Admin page to list all the chat sessions for debugging
	* 
	* @todo remove this page
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

	admin_gatekeeper();
	
	$title = elgg_view_title(elgg_echo('elggchat:title'));
	$list = elgg_view('elggchat/poll');
	
	$content = elgg_view_layout('one_sidebar', array(
	'title' => $title,
	'content' => $list,
));

	$page_data = $title . $list;

	// Display main admin menu
	echo elgg_view_page($title, $content);
