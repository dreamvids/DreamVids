
/**
 *	chat.js
 *
 *	Chat
 */

var Chat = {

	element: document.getElementById("time-real-chat-element"),

	open_click_eventlistener: null

};

Chat.init = function() {

	Chat.add_open_event();

};

Chat.add_open_event = function() {

	Chat.open_click_eventlistener = Chat.element.addEventListener("click", function(event) {
		
		Chat.element.className += " open";

	}, false);

};




window.addEventListener("DOMContentLoaded", function(event) {

	Chat.init();
	
}, false);