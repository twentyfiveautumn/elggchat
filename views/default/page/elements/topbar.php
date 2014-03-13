<?php
/**
 * ElggChat - native elgg instant messenger
 * Elgg topbar
 * The modified elgg top toolbar
 * @package elggchat
 * @author twentyfiveautumn.com
 * @copyright Coldtrick IT Solutions 2009 - twentyfiveautumn.com 2014
 * @link http://twentyfiveautumn.com.com/
 */
 
$chat_users = elgg_view_menu('topbar', array('sort_by' => 'priority', array('elgg-menu-hz')));

$old = '<li class="elgg-menu-item-chat dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle elgg-menu-closed elgg-menu-parent">Chat <b class="caret"></b></a><ul class="elgg-menu elgg-child-menu">';

$new = '<li class="elgg-menu-item-chat dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle elgg-menu-closed elgg-menu-parent">Chat <b class="caret"></b></a><ul id="chat_users" class="elgg-menu elgg-child-menu dropdown-menu">';

$chat_users = str_replace($old, $new, $chat_users);

echo $chat_users;
