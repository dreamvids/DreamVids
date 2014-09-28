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

		if(sessionId.length > 0) {
			dataArray.sessionId = sessionId;
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
	pushInfo: function(text) {
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'info';

		var contentSpan = document.createElement('span');
		contentSpan.className = 'info';

		var contentText = document.createTextNode('Info: ' + text);

		contentSpan.appendChild(contentText);
		el.appendChild(contentSpan);

		panel.appendChild(el);
		el.scrollTop = el.scrollHeight;
	},

	pushError: function(error) {
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'error';

		var contentSpan = document.createElement('span');
		contentSpan.className = 'content';

		var contentText = document.createTextNode('Error: ' + error);

		contentSpan.appendChild(contentText);
		el.appendChild(contentSpan);

		panel.appendChild(el);
		el.scrollTop = el.scrollHeight;
	},

	pushMessage: function(message) {
		var panel = document.getElementById('messages-panel');

		var el = document.createElement('div');
		el.className = 'message';

		var senderSpan = document.createElement('span');
		var contentSpan = document.createElement('span');
		senderSpan.className = 'sender';
		contentSpan.className = 'content';

		var senderText = document.createTextNode(message.sender);
		var contentText = document.createTextNode(message.content);

		senderSpan.appendChild(senderText);
		contentSpan.appendChild(contentText);

		var sepText = document.createTextNode(': ');

		el.appendChild(senderSpan);
		el.appendChild(sepText);
		el.appendChild(contentSpan);

		panel.appendChild(el);
		el.scrollIntoView();
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
		Screen.pushInfo('Connected maggle ! Welcome !');
	},

	onMessage: function(event) {
		try {
			var message = new ChatMessage();
			message.parse(event.data);

			Screen.pushMessage(message);
		}
		catch(e) {
			Screen.pushError(e.message);
		}
	},

	onDisconnect: function(event) {
		Chat.connected = false;
		Screen.pushInfo('Disconnected');
	},

	onError: function(event) {
		Screen.pushError("WebSocket error");
	}
};


function initChat(opts) {
	Chat.address = opts.address;
	Chat.port = opts.port;
	Chat.channel = opts.channel;
	Chat.username = opts.username ? opts.username : 'Dreamer';
	Chat.sessionId = opts.sessionId;

	Chat.start();
}

function sendChatMessage() {
	if(Chat.connected) {
		var contentInput = document.getElementById('message-box');
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

	var contentInput = document.getElementById('message-box');

	if(document.activeElement == contentInput && event.keyCode == 13) {
		document.getElementById('message-send').click();
	}
}

new Script({

	pages: ["live"],

	call: function() {
		console.log("blaaaa");
        console.log(liveChatOptions);
		console.log(initChat);		

		initChat(liveChatOptions);
				 
	}

});

