<?php
	/**
	* ElggChat - native elgg instant messenger
	* 
	* All the ElggChat CSS can be found here
	* 
	* @package elggchat
	* @author twentyfiveautumn.com
	* @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com.com/
	* @version 0.4
	*/

	header("Content-type: text/css", true);
?>

#elggchat_toolbar {
	position: fixed;
	bottom: 0px;
	height: 25px;
	left: 0px;
	z-index: 9999;
	background: #DEDEDE;
	font-size: 12px;
} 

*html #elggchat_toolbar {
	position: fixed;
	bottom: 0px;
	height: 25px;
	left: 0px;
	z-index: 9999;
	background: #DEDEDE;
}

#elggchat_toolbar_left {
	border-top:1px solid #CCCCCC;
	float:right;
	padding-top: 2px;
	padding-bottom: 4px;
}

.session {
	width:260px;
	float: left;
	background: #E4ECF5;
	border: 1px solid #4690D6;
	padding:3px;
    margin:0 5px 0px 5px;
 	max-width:260px;
	height: 25px;
	position:absolute;
	bottom: 0px;
}

.elggchat_session_new_messages {
	background: #333333;
}

.elggchat_session_new_messages.elggchat_session_new_messages_blink{
	background: #E4ECF5;
}

#elggchat_extensions{
	float:right;
	border-left:1px solid #CCCCCC;
	padding: 0 5px 0 5px;	
}

#elggchat_friends{
	float:right;
	border-left:1px solid #CCCCCC;
	border-right:1px solid #CCCCCC;
	padding: 0 5px 0 5px;	
}

#elggchat_friends_picker{
	display: none;
	position: absolute;
	bottom: 25px;
	right: 0px;
	background: white;
	padding: 5px;
	padding-right: 20px;
	overflow-x:hidden;
	max-height:300px;
	overflow-y: auto;
	white-space: nowrap;
	border-left:1px solid #CCCCCC;
	border-top:1px solid #CCCCCC;
	-moz-border-radius-topleft:5px; 
	-webkit-border-top-left-radius:5px;	
}

.toggle_elggchat_toolbar {
	border-top:1px solid #CCCCCC;	
	width: 15px;
	height: 100%;
	float:left;
	background:transparent url(<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/minimize.png) repeat-x left center;	
}

.minimizedToolbar {
	background-position: right center;
	border-right:1px solid #CCCCCC;
	-moz-border-radius-topright:5px; 
	-webkit-border-top-right-radius:5px;		
}

.messageWrapper {
	background:white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
    padding:10px;
    margin:0 5px 5px 5px;
}

.messageWrapper table{
	background: white;
	height: 0px;
}
.systemMessageWrapper {
	
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
    padding:3px;
    margin:0 5px 5px 5px;
	color: #999999;
}

.messageName {
	font-weight: bold;
	color: #4690D6;
}

.messageBody {
	border-top:1px solid #DDDDDD;
	width: 100%;
}

.chatsessiondatacontainer {
	width:260px;
	display: none;
}

.chatsessiondata{
	border: 1px solid #4690D6;
	border-bottom: 0px;
	background: #E4ECF5;
	margin: 0 -4px;
	position:absolute;
	bottom: 30px;
	width:266px;
	max-height:600px;
	overflow:hidden;
	wordWrap: break-word;
}

.chatmembers{
	border-bottom: 1px solid #DEDEDE;
	max-height:154px;
	overflow-y:auto;
}

.chatmember td{
	vertical-align: middle;
	padding: 5px;
}

.chatmembersfunctions {
	text-align:right;
	padding-right:2px;
	height:20px;
	border-bottom: 1px solid #DEDEDE;
}
.chatmembersfunctions_invite{
	display:none;
	text-align:left;
	position:absolute;
	background: #333333;
	width:100%;
	opacity: 0.8;
	filter: alpha(opacity=80);
	max-height:250px;
	overflow-x: hidden;
	overflow-y: auto;	
}

.chatmembersfunctions_invite a {
	color: #FFFFFF;
	padding:3px;
}

.online_status_chat{
	width:16px;
	height:16px;
	background: transparent url("<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/green.png") no-repeat 0 0;
	background-size: 10px 10px;
	background-position:center; 
}

.online_status_idle{
	background: transparent url("<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/yellow.png") no-repeat 0 0;
	background-size: 10px 10px;
	background-position:center; 
}

.online_status_inactive{
	background: transparent url("<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/red.png") no-repeat 0 0;
	background-size: 10px 10px;
	background-position:center; 
}

.elggchat_session_leave{
	margin: 2px 0 0 4px;	
	float:right; 
	cursor: pointer;
	width:14px;
	height:14px;
	background: url("<?php echo $CONFIG->wwwroot; ?>mod/elggchat/_graphics/icon_customise_remove.png") no-repeat 0 0;
}

.elggchat_session_leave:hover{
	background-position: 0 -16px;
}

.chatmessages{
	min-height: 250px;
	max-height: 400px;
	overflow-y:auto;
}

.elggchatinput{
	border-top: 1px solid #DEDEDE;
	border-bottom: 1px solid #DEDEDE;
	border: 1px solid #DEDEDE;
	height: 25px;
	width: 260px;
	overflow:hidden;
	wordWrap: break-word;
}

.elggchatinput input{
	border: none;
	font-size:100%;
	padding: 2px;
	width: 260px;
}
