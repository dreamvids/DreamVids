/*
 * Live chat
 */

 window.requestAnimationFrame = (function() {
     return window.requestAnimationFrame ||
         window.webkitRequestAnimationFrame ||
         window.mozRequestAnimationFrame ||
         function(callback) {
             window.setTimeout(callback, 1000 / 60);
     };
 })();

function ChatMessage() {
	var that = this;

	this.data = '';
	this.sender = '';
	this.content = '';
	this.messageType = 'text';
	this.channel = Chat.channel;
	this.timestamp = Math.round(+new Date() / 1000);

	this.construct = function(sender, content, sessionId) {
		that.sender = sender;
		that.content = content;

		if(content.lastIndexOf('/', 0) == 0) {
			that.messageType = 'command';
		}

		var dataArray = {
			"sender_name": that.sender,
			"content": that.content,
			"messageType": that.messageType,
			"channel": that.channel,
			"timestamp": that.timestamp
		};

		if(typeof sessionId == 'undefined') {

		}
		else {
			if(sessionId.length > 0) {
				dataArray.sessionId = sessionId;
			}
		}

		that.data = JSON.stringify(dataArray);
	};

	this.parse = function(jsonData) {
		try {
			var json = JSON.parse(jsonData);

			that.sender = json.sender_name;
			that.content = json.content;
			that.messageType = json.messageType;
			that.timestamp = json.timestamp;
		}
		catch(e) { alert(e);  }
	};

};

var Screen = {
	pushMessage: function(message) {
		var panel = document.getElementById("messages-panel");

		var el = document.createElement("div");
		el.className = "live-chat__message";

		var username = document.createElement('span');
		username.className = "live-chat__message__pseudo " + (message.rank ? "live-chat__message__pseudo--" + message.rank : "");
		var text = document.createTextNode(message.sender);
		username.appendChild(text);

		var messageElem = document.createElement('p');
		var messageText = document.createTextNode(message.content);
		messageElem.appendChild(messageText);

		el.appendChild(username);
		el.appendChild(messageElem);

		panel.appendChild(el);

		Chat.scrollDown();

		var maxMessagesInList = 32;

		if (panel.childNodes.length > maxMessagesInList) {

			for (var i = 0; panel.childNodes.length > maxMessagesInList;) {
				
				panel.removeChild(panel.childNodes[i])
			
			}

		}

	},

	pushText: function(message, type) {
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'live-chat__message ' + "live-chat__message--" + type;

		var messageElem = document.createElement('p');

		var typeText = {

			error: "Erreur",
			info: "Information"

		};

		var messageText = document.createElement('span');
		messageText.className = 'live-chat__message__pseudo';
		messageText.innerHTML = (typeText[type] || type) + ' : ' + message;

		messageElem.appendChild(messageText);

		el.appendChild(messageElem);

		panel.appendChild(el);
		panel.scrollTop = panel.scrollHeight;


	},


	clearFirst: function() {
		var panel = document.getElementById('messages-panel');
		panel.removeChild(panel.firstChild);
	}
};

var Chat = {

	connected: false,
	socket: null,
	address: '127.0.0.1',
	port: 8080,
	channel: '',
	username: 'Dreamer',
	sessionId: '',
	scrolling: false,
	isHover: false,
	scrollSpeed: 0,

	start: function() {
		this.socket = new WebSocket('ws://' + this.address + ':' + this.port + '/' + this.channel);

		this.socket.onopen = this.onConnect;
		this.socket.onclose = this.onDisconnect;
		this.socket.onmessage = this.onMessage;
		this.socket.onerror = this.onError;

	},

	onConnect: function(event) {
		// send an empty message to init the connection
		var msg = new ChatMessage();
		msg.construct(Chat.username, '', Chat.sessionId);
		Chat.socket.send(msg.data);

		Chat.connected = true;
		Screen.pushText('Connected maggle ! Welcome !', 'info');
	},

	onMessage: function(event) {
		try {
			var message = new ChatMessage();
			message.parse(event.data);

			Screen.pushMessage(message);
		}
		catch(e) {
			Screen.pushText(e.message, 'error');
		}
	},

	onDisconnect: function(event) {
		Chat.connected = false;
		Screen.pushText('Disconnected', 'info');
	},

	onError: function(event) {
		Screen.pushText("WebSocket error", 'error');
	},

	scrollDown: function() {

		if (!Chat.scrolling && !Chat.isHover) {

			Chat.scrollInterval();

		}

	},

	scrollInterval: function() {

		var panel = document.getElementById("messages-panel");

	    Chat.scrolling = true;
	    speed = Math.abs(panel.scrollTop + panel.offsetHeight - panel.scrollHeight) / 12 + 1;
	    Chat.scrollSpeed += Chat.scrollSpeed < speed ? speed / 5 : -speed / 8;

	    panel.scrollTop += !Chat.isHover ? Chat.scrollSpeed : 0;

	    if (panel.scrollTop + panel.offsetHeight < panel.scrollHeight) {

	        requestAnimationFrame(Chat.scrollInterval);

	    }

	    else {

	        Chat.scrollSpeed = 0;
	        Chat.scrolling = false;

	    }

	}

};

function initChat(opts) {

	Chat.address = opts.ip;
	Chat.port = opts.port;
	Chat.channel = opts.channel;
	Chat.username = opts.username ? opts.username : 'Dreamer';
	Chat.sessionId = opts.sessionId;

	window.onkeypress = keyPress;

	Chat.start();

	var panel = document.getElementById("messages-panel");

	panel.addEventListener("mouseover", function() {

	    Chat.isHover = true;

	});

	panel.addEventListener("mouseout", function() {

	    Chat.isHover = false;

	});

	panel.addEventListener("mousewheel", function(event) {

	    panel.scrollTop += event.wheelDelta > 0 || event.detail < 0 ? -30 : 30;

	});

}

function sendChatMessage() {
	if(Chat.connected) {
		var contentInput = document.getElementById('live-chat-input');
		var message = new ChatMessage();

		message.construct(Chat.username, contentInput.value, Chat.sessionId);

		Chat.socket.send(message.data);
		contentInput.value = '';
	}
}

function keyPress(event) {
	if(typeof event == 'undefined' && window.event)
		event = window.event;

	var contentInput = document.getElementById('live-chat-input');

	if(document.activeElement == contentInput && event.keyCode == 13) {
		sendChatMessage();
	}
}

new Script({

	pages: ["live"],

	call: function() {

		initChat(chatLiveOptions);

	}

});