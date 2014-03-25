<?php
	/**
	* ElggChat - native elgg instant messenger
	* 
	* All the javascript/JQuery functions are in this file
	* 
	* @package elggchat
	* @author twentyfiveautumn.com
	* @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
	* @link http://twentyfiveautumn.com.com/
	* @version 0.4
	*/

	global $CONFIG;
	$basesec = elgg_get_plugin_setting("chatUpdateInterval","elggchat");
	if(!$basesec) $basesec = 5;
	$maxsecs = elgg_get_plugin_setting("maxChatUpdateInterval","elggchat");
	if(!$maxsecs) $maxsecs = 30;
	
	$sound = '"'.elgg_get_plugin_setting("enableSounds","elggchat").'"';
	if(empty($sound)) $sound = "no";
	
	$flash = '"'.elgg_get_plugin_setting("enableFlashing","elggchat").'"';
	if(empty($flash)) $flash = "no";
	
	header('Content-type: text/javascript');
?>
	var sessions = {
		flash: <?php echo $flash; ?>,
		sound: <?php echo $sound; ?>,
	}

	var flash =   <?php echo $flash; ?>;
	var basesec = <?php echo $basesec;?>;
	var maxsecs = <?php echo $maxsecs;?>;
	var delay = 1000;
	
	var secs;
	var processing = false;
	var pollingPause = false;
	var lastTimeDataReceived = new Date().getTime();
		
	function InitializeTimer(){
	
		// Set the length of the timer, in seconds
		secs = basesec;
		tick();
		<?php if($flash == "yes"){?>
		blink_new();
		<?php }?>
	}
	
	function blink_new(){
	//	$(".elggchat_session_new_messages").toggleClass("elggchat_session_new_messages_blink");
	
	// $("elggchat_sessions > div.session").css("background-color", "lime");
		
	//	$(".elggchat_session_new_messages").fadeTo(100, 0.1).fadeTo(200, 1.0);
	
	//	self.setTimeout("blink_new()", 1000);
	}

	function tick(){
		if(!pollingPause){
			if(!processing){
				if (secs == 0){
					checkForSessions();			// turn this back on after		
				} else {
					secs = secs - 1;
				}
			} else {
				resetTimer();
			}
			
			self.setTimeout("tick()", delay);
		}
	}
	
	function resetTimer(){
		// if needed apply multiplier
		var currentTimeStamp = new Date().getTime();
		var timeDiff = (currentTimeStamp - lastTimeDataReceived) / 1000;
		
		var interval = Math.ceil((Math.sqrt(Math.pow(basesec * 10 / 2, 2) + (2 * basesec * 10 * timeDiff)) - (basesec * 10 / 2)) / (basesec * 10));
		// reset secs
		secs = basesec * interval;
		if(secs > maxsecs){
			secs = maxsecs;
		}
	}
	
/*****	@todo - gonna need a re-write to be able to add more than one friend to a chat session	*****/
		
	function inviteFriends(sessionid){
		var currentChatWindow = $("#" + sessionid + " .chatmembersfunctions_invite"); 
		if(currentChatWindow.css("display") != "block"){
			currentChatWindow.html("");
			$("#elggchat_friends_picker .chatmemberinfo").each(function(){
				var friend = $(this).find("a");
				if(!($("#" + sessionid + " .chatmember a[rel='" + friend.attr('rel') + "']").length > 0)){
					newFriend = "<a href='javascript:addFriend(" + sessionid + ", " + friend.attr('rel') + ")'>";
					newFriend += friend.html();
					newFriend += "</a><br />";
					currentChatWindow.append(newFriend);
				}
			});
		}
		currentChatWindow.slideToggle();
	}
/******************************************************************************************************/	
	function addFriend( sessionid, friend ){
	
		var thisURL = elgg.config.wwwroot + 'ajax/view/elggchat/invite';

		$.post(thisURL, { chatsession : sessionid, friend : friend }, function(){
		
			$("#" + sessionid + " .chatmembersfunctions_invite").toggle();
			checkForSessions();
			$("#" + sessionid + " input[name='chatmessage']").focus();
		});
	}	
	
	function leaveSession(sessionId){
	
		alert("function leaveSession: "+sessionId);
	
		if(confirm("<?php echo elgg_echo('elggchat:chat:leave:confirm');?>")){
			var thisURL = elgg.config.wwwroot + 'ajax/view/elggchat/leave';
			$.post(thisURL, { chatsession : sessionId }, function(){
				$("#" + sessionId).fadeOut("slow").remove();
			//	checkForSessions();
			});
		} 
	}
	
	function startSession(friendGUID){
	
		alert("function startSession: friensGUID = "+friendGUID);
	
		var thisURL = elgg.config.wwwroot + 'ajax/view/elggchat/create';
		$.post(thisURL, { friendGUID: friendGUID }, function(data){
		var obj = jQuery.parseJSON(data);
		sessions[obj.id] = {
			friend : {
				"guid": obj.friend.guid,  
				"name": obj.friend.name,
			}
		};
		
		if(!data){
			alert("function startSession did not create a new session");
		}
		
		var sessionGUID = obj.id;
		var firsttime = true;
		checkForSessions(firsttime)
		});
	}
	
	/*****	scroll to the bottom of chat messages so you can see the newest messages	*****/
		
	function scroll_to_bottom(sessionid){
	
		alert("Line 170: function scroll_to_bottom: sessionid = "+sessionid);
	
		var chat_window = $("#" + sessionid +" .chatsessiondata");
		var chatMessages = chat_window.find(".chatmessages");
		$(chatMessages).scrollTop($(chatMessages)[0].scrollHeight);
	}
	
	function notify_new_message(){
		<?php if($sound == "yes"){?>
		$.sound.play("<?php echo $CONFIG->wwwroot; ?>mod/elggchat/js/sound/new_message.wav");
		<?php }?>
	}
	
	function checkForSessions(firsttime){
	
	//	alert("Line:185 function checkForSessions: firsttime: "+firsttime);
		
		if (typeof firsttime === "undefined") { 
			firsttime = false;
			}
			
			processing = true;			// Starting the work, so stop the timer
			var thisURL = elgg.config.wwwroot + 'ajax/view/elggchat/poll';
			$.post(thisURL, function(data){
			
		alert("Line:195 "+JSON.stringify(data));	
			
			if(typeof(data.sessions) !== "undefined"){ 
				
				
				/*****	check to see if the session is alredy in the document	*****/
				$.each(data.sessions, function(i, session){
				
			var sessionGUID = i;
	
		alert("Session: "+sessionGUID+" value: "+$("#"+sessionGUID).val());
		
		var friend = session.name;
				
			var current = sessionGUID;	
				
					var sessionExists = false;
					$("#" + i).each(function(){
						sessionExists = true;
						alert("session exists: "+i);
					});
				
		//			if(sessionExists === false){
						
						var newSession = {};
						newSession.members = [];
						newSession.messages = "";
						newSession.friend = "";
						
						
					alert("TYPE: "+typeof(session.name));
						
						if(typeof(session.name) != "undefined"){
							$.each(session.name, function(Num, name){
								newSession.friend += name;
							});
						}
						
					
								
						if(typeof(session.members) != "undefined"){
							$.each(session.members, function(memNum, member){
								newSession.members[memNum] = member;
							});
						}
						
				
						
						if(typeof(session.messages) != "undefined"){
							$.each(session.messages, function(msgNum, msg){
							//	newSession.messages[msgNum] = msg.replace(/[\n\r]/g, '');	// strip carriage returns
							//	var msg = msg.replace(/[\n\r]/g, '');	// strip carriage returns
								newSession.messages += '<li class="list-group-item" id="'+msgNum+'">'+msg+'</li>';
							});
						}
											
				//		newSession.messages += '<li class="list-group-item" id="'+12+'">'+'new test message'+'</li>'; 
						
						/***** session is not in the document so lets build it *****/
						
		alert("LINE 281: building new session.");
		alert("line 285 "+JSON.stringify(newSession.messages));	
		
		if(sessionExists === false){
		
		
						$("#chat-panel-template div").first().prop( "id", sessionGUID );
						$("#chat-panel-template").find("h3").prepend(newSession.friend);
						$("#chat-panel-template").find("input[name='chatsession']").val(sessionGUID);
						$("#chat-panel-template").find("#message_window").append(newSession.messages);
						var chatPanel = $("#chat-panel-template").html();
						$("#elggchat_sessions").append(chatPanel);
						resetTemplate();
						
						firsttime = false;
						
						/***** new session added to document *****/
						
					} else {
					
					$("#"+sessionGUID).find("#message_window").append(newSession.messages);
					
					
					alert("Line 301: session exists: "+i);
					
						var newSession = {};
						newSession.members = [];
						newSession.messages = "";
						newSession.friend = "";
				alert("TYPE OF SESSION MESSAGES: "+typeof(data.sessions));	
						if(typeof(session.members) != "undefined"){
							$.each(session.members, function(memNum, member){
								newSession.members[memNum] = member;
							});
						}
						
			alert("line 289: "+JSON.stringify(session.messages));
			
			
						if(typeof(session.messages) != "undefined"){
							$.each(session.messages, function(msgNum, msg){
							//	newSession.messages[msgNum] = msg.replace(/[\n\r]/g, '');	// strip carriage returns
								var msg = msg.replace(/[\n\r]/g, '');	// strip carriage returns
								newSession.messages += '<li class="list-group-item" id="'+msgNum+'">'+msg+'</li>';
							});
						}
											
						newSession.messages += '<li class="list-group-item" id="'+12+'">'+'new test message'+'</li>';
						
						
						
						
						var messageData = "";
					//	var cookie = readCookie("elggchat_session_" + i);
						
					//	var lastKnownMsgId = 0;
					//	if(cookie > 0){
					//		var lastKnownMsgId = parseInt(readCookie("elggchat_session_" + i));
					//	} 
	
						if(typeof(session.messages) != "undefined"){
							$.each(session.messages, function(msgNum, msg){
								if(msgNum > lastKnownMsgId || lastKnownMsgId == NaN){
									messageData += msg;
									lastTimeDataReceived = new Date().getTime();
								}
							});
						}
						$("#" + i + " .chatmessages").append(messageData);		
						
					}	// end }else{ from line 266
				
				
				});
				
				
				
				
				
				// search for new data
				$(".session").each(function(){
				
					var sessionid = $(this).attr("id");
					var lastKnownMsgId = parseInt(readCookie("elggchat_session_" + sessionid));
					var newestMsgId = parseInt($("#" + sessionid + " .chatmessages div:last").attr("id"));
					
					if(newestMsgId > lastKnownMsgId || !lastKnownMsgId){
						if($(this).find(".chatsessiondatacontainer").css("display") != "block" && newestMsgId){
							if(!($("#" + sessionid).hasClass("elggchat_session_new_messages")) && !firsttime){	
								notify_new_message();
							}
							$("#" + sessionid).addClass("elggchat_session_new_messages");
								
							lastTimeDataReceived = new Date().getTime();
							
						}
					}
				
				});
				
			}
			
			/*****	topbar friends online notifier	*****/
								
			if(typeof(data.friends) !== "undefined"){
				
				/*****	lets see how many friends are online	*****/
	
				var numOnline = data.friends.online.length;		// the number of friends who are online
				
				if(numOnline > 0){
				    $(".elgg-menu-item-chat > a > span").remove();
					friendsOnline = '<span class="badge">'+numOnline+'</span>';
					$(".elgg-menu-item-chat > a").append(friendsOnline);
				}
			}
			
			/*****	End topbar friends online notifier	*****/
			
			resetTimer();
			processing = false;			// we can turn off polling by setting this to true or commenting it out
		});
	}
	
	function openSession(id){
	
	//	$("#"+ id).removeClass("elggchat_session_new_messages");
		var current = $("#" + id + " .chatsessiondatacontainer").css("display");
		eraseCookie("elggchat");
		$("#elggchat_sessions .chatsessiondatacontainer").hide();
		if(current != "block"){
			createCookie("elggchat", id);
			var last = $("#" + id + " .chatmessages div:last").attr("id");
			createCookie("elggchat_session_" + id, last); 
			$("#" + id + " .chatsessiondatacontainer").toggle();
		}	
		scroll_to_bottom(id);
		$("#" + id + " input[name='chatmessage']").focus();
	}
	
	function resetTemplate() {
		alert("function resetTemplate");
	
		$("#chat-panel-template div").first().prop( "id", "" );
		$("#chat-panel-template").find("h3").text("");
		$("#chat-panel-template").find("input[name='chatsession']").val("");
		$("#chat-panel-template").find("#message_window").html("");
		
		var original = "<span class=\"glyphicon glyphicon-remove-circle pull-right\"></span>";
		original += "<span class=\"glyphicon glyphicon-minus pull-right\"></span>";
		original += "<span class=\"glyphicon glyphicon-cog pull-right\"></span>";
		$("#chat-panel-template").find("h3").html(original);
		return;
	}
	
	/*****	Cookie Functions	*****/
	function createCookie(name, value, days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			var expires = "Expires=" + date.toGMTString() + "; ";
		} else {
			var expires = "";
		}
		
		document.cookie = name + "=" + value + "; " + expires + "Path=/;";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');

		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];

			while (c.charAt(0) == ' '){
				c = c.substring(1, c.length);
			}
			
			if (c.indexOf(nameEQ) == 0){
				return c.substring(nameEQ.length, c.length);
			}
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name, "", -1);
	}	

$(document).ready(function () {
  //  InitializeTimer();
 //   checkForSessions(true);	//turn this back on after....

    /*****	make the topbar chat menu work	*****/

    $("#chat_users > li > a").click(function (event) { //	START: a friends name was clicked on the menu
        event.preventDefault();
        var friendGUID = $(this).attr("rel");
        startSession(friendGUID);
    });

    /*****	turn on topbar menu tooltips	*****/
    $(".chat_status").tooltip();

    /*****	operate the buttons in the header	*****/

    // attach a delegated event
    $("#elggchat_sessions").on("click", "span", function (event) {
        event.preventDefault();
        var test = $(this).attr("class");
        var sessionId = $(this).parent().parent().parent().attr("id");
		var panel = $(this).parent().parent().parent();
		
        alert("LINE: 502 session Id: " + sessionId);
		
		alert(test);

        switch (test) {
            case "glyphicon glyphicon-remove-circle pull-right":
                leaveSession(sessionId);
                break;
            case "glyphicon glyphicon-minus pull-right":
                alert("You Clicked on the minimize");
				
				var small = $("#elggchat_sessions").find(".panel-body").height();

                //$("#elggchat_sessions").find(".panel-body");
				
			//	alert(small);
				
			//	$(panel).height( "18px");
			//	$(panel).collapse();
				$(panel).find(".panel-body").collapse();

                break;
            case "glyphicon glyphicon-cog pull-right":
                alert("You Clicked on the cog");
                break;
            default:
                alert("something went wrong");
        }

    });



    /*****	open/close the chat panel	*****/

   
    /***** submit using enter button	*****/

    // attach a delegated event
    $("#elggchat_sessions").on("keypress", "#chatmessage", function (event) {

        if (event.which == 13) {
            event.preventDefault();
         
         alert($(this).val());
		 
			var panel = $(this).parent().parent().parent();
			var chatmessage = $(this).val();
			var chatsession = $(panel).find("#chatsession").val();
			var form = { chatmessage: chatmessage, chatsession:chatsession};
		//	var form = $(panel).find(".form-inline");
			
		// alert("FORM: "+form);	
			if($(this).val() != ""){
				var thisURL = elgg.config.wwwroot + "ajax/view/elggchat/list";
				
				$(panel).find("#chatmessage").val("");
				
				$.post( thisURL, function( data ) {
				
				alert("back: "+data);
					
				});
				
				
				checkForSessions();
							
						
			}
					// empty the input field
					
					return false;
			
        }
    });

}); /*****	end (document).ready	*****/	

//	alert(JSON.stringify(data));
//	alert(typeof(data.sessions));	
//	var obj = jQuery.parseJSON(data);

//$(this).find("#message_window).appendl("");
