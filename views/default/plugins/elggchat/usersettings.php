<?php 
	/**
	* ElggChat - Pure Elgg-based chat/IM
	* 
	* Definition of the user settings
	* 
	* @package elggchat
	* @author ColdTrick IT Solutions
	* @copyright Coldtrick IT Solutions 2009
	* @link http://www.coldtrick.com/
	* @version 0.4
	*/

	$user_guid = elgg_get_logged_in_user_guid();
 	$enable_chat = elgg_get_plugin_user_setting('enableChat', $user_guid, 'elggchat');
	$allow_contact_from = elgg_get_plugin_user_setting('allow_contact_from', $user_guid, 'elggchat');

$enable_chat_label = elgg_echo('elggchat:usersettings:enable_chat');
$enable_chat_view = elgg_view('input/select', array(
	'name' => 'params[enableChat]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	),
	'value' => $enable_chat ? $enable_chat : 'no',
));

$new_users_with_twitter = elgg_echo('elggchat:usersettings:allow_contact_from');
$new_users_with_twitter_view = elgg_view('input/select', array(
	'name' => 'params[allow_contact_from]',
	'options_values' => array(
		'all' => elgg_echo('elggchat:usersettings:allow_contact_from:all'),
		'friends' => elgg_echo('elggchat:usersettings:allow_contact_from:friends'),
		'none' => elgg_echo('elggchat:usersettings:allow_contact_from:none'),
	),
	'value' => $allow_contact_from ? $allow_contact_from : 'none',
));

$settings = <<<__HTML
<div>$enable_chat_label $enable_chat_view</div>
<div>$new_users_with_twitter $new_users_with_twitter_view</div>
__HTML;

echo $settings;
