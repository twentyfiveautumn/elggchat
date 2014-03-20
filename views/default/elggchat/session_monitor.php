<?php
	/**
	* ElggChat - native elgg instant messenger
	* 
	* Builds the ElggChat Toolbar
	* 
	* @package elggchat
	* @author twentyfiveautumn.com
	* @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com.com/
	* @version 0.4
	*/
	
?>
<div id="elggchat_toolbar">
	<div id="elggchat_toolbar_left" >
		<div id='elggchat_sessions'> 
		</div>
		<div id="elggchat_friends">
			<a href="javascript:toggleFriendsPicker();"></a>
		</div>
		<div id="elggchat_friends_picker">
		</div>
	</div>
	<div id="toggle_elggchat_toolbar" class="toggle_elggchat_toolbar" onclick="toggleChatToolbar('slow')" title="<?php echo elgg_echo("elggchat:toolbar:minimize");?>">
	</div>
</div>
