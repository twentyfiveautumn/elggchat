<?php
	/**
	* ElggChat - native elgg instant messenger
	* 
	* Admin settings
	* 
	* @package elggchat
	* @author twentyfiveautumn.com
	* @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com.com/
	* @version 0.4
	*/

	$chatUpdateInterval = elgg_get_plugin_setting('chatUpdateInterval', 'elggchat');
	$maxChatUpdateInterval = elgg_get_plugin_setting('maxChatUpdateInterval', 'elggchat');
//	$monitorUpdateInterval = $vars['entity']->monitorUpdateInterval;	<------------------------------not sure what this one is for? leave it for now
	$maxSessionAge = elgg_get_plugin_setting('maxSessionAge', 'elggchat');
	$onlinestatus_active = elgg_get_plugin_setting('onlinestatus_active', 'elggchat') ? elgg_get_plugin_setting('onlinestatus_active', 'elggchat') : 60 ;
	$onlinestatus_inactive = elgg_get_plugin_setting('onlinestatus_inactive', 'elggchat') ? elgg_get_plugin_setting('onlinestatus_inactive', 'elggchat') : 600 ;
	
	$enableSounds = elgg_get_plugin_setting('enableSounds', 'elggchat')? elgg_get_plugin_setting('enableSounds', 'elggchat') : 'no';
	$enableFlashing = elgg_get_plugin_setting('enableFlashing', 'elggchat')? elgg_get_plugin_setting('enableFlashing', 'elggchat') : 'no';
	$enableExtensions = elgg_get_plugin_setting('enableExtensions', 'elggchat')? elgg_get_plugin_setting('enableExtensions', 'elggchat') : 'no';
?>
<p>

<?php	
	echo elgg_view('input/select', array(
	'name' => 'params[chatUpdateInterval]',
	'options_values' => array(
		'5' => 5,
		'10' => 10,
		'15' => 15,
	),
	'value' => $chatUpdateInterval,
	));
	
	?>
	
	<?php echo elgg_echo('elggchat:admin:settings:chatupdateinterval'); ?><br />

	<?php	
	echo elgg_view('input/select', array(
	'name' => 'params[maxChatUpdateInterval]',
	'options_values' => array(
		'15' => 15,
		'30' => 30,
		'45' => 45,
		'60' => 60,
	),
	'value' => $maxChatUpdateInterval,
	));
	
	?>
	
	<?php echo elgg_echo('elggchat:admin:settings:maxchatupdateinterval'); ?><br />

	<?php	
	echo elgg_view('input/select', array(
	'name' => 'params[maxSessionAge]',
	'options_values' => array(
		'3600' => sprintf(elgg_echo("elggchat:admin:settings:hours"), 1),
		'21600' => sprintf(elgg_echo("elggchat:admin:settings:hours"), 6),
		'43200' => sprintf(elgg_echo("elggchat:admin:settings:hours"), 12),
		'86400' => sprintf(elgg_echo("elggchat:admin:settings:hours"), 24),
	),
	'value' => $maxSessionAge,
	));
	
	?>
	<?php echo elgg_echo('elggchat:admin:settings:maxsessionage'); ?><br />
	
	<br />
	<?php echo elgg_echo('elggchat:admin:settings:online_status:active') . elgg_view("input/text", array("name"=>"params[onlinestatus_active]", "value"=>$onlinestatus_active));?>
	
	<br />
	<?php echo elgg_echo('elggchat:admin:settings:online_status:inactive') . elgg_view("input/text", array("name"=>"params[onlinestatus_inactive]", "value"=>$onlinestatus_inactive));?>
	
	<br />
	<?php
	echo elgg_view('input/select', array(
	'name' => 'params[enableSounds]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	),
	'value' => $enableSounds ? $enableSounds : 'no',
));
	?>
	<?php echo elgg_echo('elggchat:admin:settings:enable_sounds'); ?><br />

	<?php
	echo elgg_view('input/select', array(
	'name' => 'params[enableFlashing]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	),
	'value' => $enableFlashing ? $enableFlashing : 'no',
));
	?>
	<?php echo elgg_echo('elggchat:admin:settings:enable_flashing'); ?><br />

	<?php
	echo elgg_view('input/select', array(
	'name' => 'params[enableExtensions]',
	'options_values' => array(
		'yes' => elgg_echo('option:yes'),
		'no' => elgg_echo('option:no'),
	),
	'value' => $enableExtensions ? $enableExtensions : 'no',
));
	?>
	<?php echo elgg_echo('elggchat:admin:settings:enable_extensions'); ?><br />
</p>
