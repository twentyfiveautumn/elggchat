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

.session {
	width:260px;
	float: left;
	background: #FAFAFA;
	border: 1px solid #777777;
	border-top: 0px;
	padding:3px;
    margin:0 5px 0 5px;
 	max-width:260px;
	height: 30px;
	bottom: 0px;
	font-weight: bold;
}

.elggchat_session_new_messages {
	background: #333333;
}

.elggchat_session_new_messages.elggchat_session_new_messages_blink{
	background: #E4ECF5;
}

.messageWrapper {
	background:white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
    padding: 5px;
    margin:0 2px 2px 2px;
	border:1px solid #CCCCCC;
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
	font-weight: normal;
}

.chatsessiondatacontainer {
	width:260px;
	display: none;
}

.chatsessiondata{
	border: 1px solid #4690D6;
	border: 1px solid #777777;
	border-bottom: 0px;
	background: #E4ECF5;
	margin: 0 -4px;
	position:absolute;
	bottom: 23px;
	width:266px;
	max-height:600px;
	overflow:hidden;
	wordWrap: break-word;
}

.chatmembers{
	max-height:154px;
	overflow-y:auto;
	background-color: #FAFAFA;
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
	background-color: #FAFAFA;
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
	background-size: 10px;
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
	max-height: 325px;
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


#chat_users > li > a > div > img {
	padding-right: 10px;
}

.chat_status {
	height: 10px;
	vertical-align:center; 
	padding-left: 10px;
}

/*****	this is the topbar badge of how many chat users are online	*****/

.elgg-menu-item-chat > a > span {
	margin-left: 5px;
	background-image: linear-gradient(to bottom, #5CB85C 0px, #419641 100%);
	background-repeat: repeat-x;
}
