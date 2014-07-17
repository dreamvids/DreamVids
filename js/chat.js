
/**
 *	chat.js
 *
 *	Chat
 */

var Chat = {

	element: document.getElementById("time-real-chat-element"),
	close_icon: document.getElementById("time-real-chat-close")

};

Chat.init = function() {

	Chat.add_open_event();

};

Chat.add_open_event = function() {

	Chat.element.addEventListener("click", Chat.on_open_event, false);

};

Chat.on_open_event = function(event) {

	Chat.element.className += " open";

	Chat.element.removeEventListener("click", Chat.on_open_event, false);

	Chat.add_close_event();

};

Chat.add_close_event = function() {

	Chat.close_icon.addEventListener("click", Chat.on_close_event, false);

};

Chat.on_close_event = function(event) {

	Chat.element.className += " close";

	Chat.close_icon.removeEventListener("click", Chat.on_close_event, false);

	setTimeout(function() {

		Chat.element.className = Chat.element.className.replace("close", "");
		Chat.element.className = Chat.element.className.replace("open", "");

		Chat.add_open_event();

	}, 100);

};




window.addEventListener("DOMContentLoaded", function(event) {

	Chat.init();
	
}, false);