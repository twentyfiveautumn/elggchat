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
	* @version 0.5
	*/
	
?>
	<div class="container">									
		<div class="row" id="elggchat_sessions">
		</div>												
	</div>	
	
<!----------	start the chat-panel-template --------------------------------------------------------------------------------------------------------------------------------------------------------->

<div id="chat-panel-template">

			<div class="panel panel-primary col-md-3">								<!--	******************************* this is the start of the Panel	******************	-->
				<div class="panel-heading">													<!-- start Panel Heading	-->
					<h3 class="panel-title">
						<span class="glyphicon glyphicon-remove-circle pull-right"></span>
						<span class="glyphicon glyphicon-minus pull-right"></span>
						<span class="glyphicon glyphicon-cog pull-right"></span>
					</h3>
				</div>																		<!-- end Panel Heading		-->
				
				
				<div class="panel-body">
					<div class="panel panel-default">
						<div class="panel-body">
							<ul class="list-group" id="message_window" name="message_window">
					<!--			<li class="list-group-item">Single Message</li>				// left here as a refference	-->
							</ul>
						</div>
					</div>
					
					<div class="panel panel-default">
						<div class="panel-body">
						
				<!--			Input form	-->
							
							<form class="form-inline" role="form">
								<div class="form-group">
									<label class="sr-only" for="exampleInputEmail2">Email address</label>
									<textarea class="form-control" rows="1" placeholder="Input form" name="chatmessage" id="chatmessage" autocomplete="off"></textarea>
								</div>
								
								<div class="form-group">
									<label class="sr-only" for="chatsession">Password</label>
									<input type="hidden" class="form-control" id="chatsession" name="chatsession" />
								</div>
							</form>
							
							
							
						</div>
					</div>
				</div>
			</div>																		<!--	******************************* this is the end of the Panel	******************	-->
</div>


<!----------	end the chat-panel-template --------------------------------------------------------------------------------------------------------------------------------------------------------->


<!---	https://api.jquery.com/jQuery.parseJSON/		-->	

<!-- div id='elggchat_sessions'></div -->
