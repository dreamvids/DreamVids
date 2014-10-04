/*
 * Live chat
 */

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
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'live-chat__message';

		var avatar = document.createElement('img');
		avatar.className = 'live-chat__message__avatar';
		avatar.setAttribute('src', 'http://lorempicsum.com/simpsons/255/200/5');

		var username = document.createElement('span');
		username.className = 'live-chat__message__pseudo';
		var text = document.createTextNode(message.sender);
		username.appendChild(text);

		var messageElem = document.createElement('p');
		var messageText = document.createTextNode(message.content);
		messageElem.appendChild(messageText);

		el.appendChild(avatar);
		el.appendChild(username);
		el.appendChild(messageElem);

		panel.appendChild(el);
		el.scrollTop = el.scrollHeight;
	},

	pushText: function(message, type) {
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'live-chat__message';

		var messageElem = document.createElement('p');
		var messageText = document.createTextNode(type + ': ' + message);
		messageElem.appendChild(messageText);

		el.appendChild(messageElem);

		panel.appendChild(el);
		el.scrollTop = el.scrollHeight;
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
		msg.construct(Chat.username, '');
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
	}
};


function initChat(opts) {
	//Chat.address = opts.ip;
	Chat.address = '127.0.0.1';
	Chat.port = opts.port;
	Chat.channel = opts.channel;
	Chat.username = opts.username ? opts.username : 'Dreamer';
	Chat.sessionId = opts.sessionId;

	window.onkeypress = keyPress;

	Chat.start();
}

function sendChatMessage() {
	if(Chat.connected) {
		var contentInput = document.getElementById('live-chat-input');
		var message = new ChatMessage();

		message.construct(Chat.username, contentInput.value, Chat.sessionId);

		Chat.socket.send(message.data);
		Screen.pushMessage(message);

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


