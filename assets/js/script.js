
/**
 * main.js
 *
 * Fichier JavaScript principal.
 */

var Application = {

	name: "DreamVids"

};

/**
 * core/request-animation-frame.js
 *
 * REQUEST ANIMATION FRAME
 */

window.requestAnimationFrame = (function() {

    return window.requestAnimationFrame       ||
           window.webkitRequestAnimationFrame ||
           window.mozRequestAnimationFrame    ||

        function(callback) {

            window.setTimeout(callback, 1000 / 60);

    	};

})();

/**
 * components/main.js
 *
 * Button component
 */

new Component({

	name: "btn",

	render: function($) {

		var type = $.type === "raised" ? "raised" : "flat",
			color = $.color ? ".btn--" + $.color : "",
			outline_color = $.outline ? ".btn--outline-" + $.outline : "",
			ripple_color = $.ripple ? ".btn--ripple-" + $.ripple : "",
			disabled = isset($.disable) ? ".disabled" : "";
	
		var btn = new Element("div.btn.btn--" + type + color + outline_color + ripple_color + disabled);
	
		if (!disabled) {
	
			btn.tabIndex = 0;
	
		}

		if (typeof $.click === "function") {

			El(btn).on("CLICK", $.click, btn);

		}
	
		if (!$["no-ripple"]) {
	
			El(btn).add(Co('<ripple parent="${parent}"/>', {
	
				parent: btn
	
			}));
	
		}

		return btn;
	
	}

});

/* TEMPLATE

<btn type="flat|raised" color? click? no-ripple?>@{inner}</btn> */

/**
 * Components/card.js
 *
 * Card component
 */

new Co({

	name: "card",

	render: function($) {

		var type = isset($.type) ? $.type : "video";
	
		if (type === "video") {
	
			var card = new El("div.card.video");
	
				var thumbnail = card.add(new El("div.thumbnail"));
				thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var time = thumbnail.add(new El("div.time"));
					time.innerHTML = $.duration;
	
					var overlay = thumbnail.add(new El("a.overlay"));
					overlay.href = "watch/" + $["vid-id"];
	
				var description = card.add(new El("div.description"));
	
					var title = description.add(new El("a"));
					title.href = "watch/" + $["vid-id"];
	
						var title_inner = title.add(new El("h4"));
						title_inner.innerHTML = $.title;
	
					var div = description.add(new El("div"));
	
						var views = div.add(new El("div.view"));
						views.innerHTML = $.views;
	
						var channel = div.add(new El("a.channel"));
						channel.href = "channel/" + $.channel;
						channel.innerHTML = $["channel-name"];
	
		}
	
		else if (type == "plus") {
	
			var card = new El("div.card.plus");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var thumbnail = a.add(new El("div.thumbnail"));
					thumbnail.style.backgroundImage = "url(" + $.thumbnail + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a aimé votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "comment") {
	
			var card = new El("div.card.comment");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $["vid-id"];
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
	
						p.innerHTML += " a commenté votre vidéo \"<b>" + $["vid-name"] + "</b>\"";
	
					var blockquote = a.add(new El("blockquote"));
					blockquote.innerHTML = $.comment
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		else if (type == "channel") {
	
			var card = new El("div.card.channel");
	
				var a = card.add(new El("a"));
				a.href = "watch/" + $.channel;
	
					var avatar = a.add(new El("div.avatar"));
					avatar.style.backgroundImage = "url(" + $.avatar + ")";
	
					var p = a.add(new El("p"));
	
						var channel_name = p.add(new El("b"));
						channel_name.innerHTML = $["channel-name"];
		
						p.innerHTML += " s'est abonné à votre chaîne \"<b>" + $["my-channel-name"] + "</b>\"";
	
				var subscribers = card.add(new El("span.subscribers"));
				subscribers.innerHTML = "<b>" + $.subscribers + "</b> Abonnés";
	
				var i = card.add(new El("i"));
				i.innerHTML = $["relative-time"];
	
		}
	
		card.on( "CLICK", $.click, card);

		return card;
	
	}

});

/**
 * Components/channel-post.js
 *
 * Channel social post component
 */

new Co({

	name: "channel-post",

	render: function($) {

		var channel_post = new Element("div.channel-post");
	
			var avatar = channel_post.add(new Element("img"));
			avatar.src = $.avatar;
	
			var p = channel_post.add(new Element("p"));
	
				var channel_name = p.add(new Element("span.channel-name"));
				channel_name.innerHTML = $.channel;
	
			p.innerHTML += " a posté un message :";
	
			var message = channel_post.add(new Element("div.social-message"));
			message.innerHTML = $.message;
	
		return channel_post;
	
	}

});

/* TEMPLATE

<div class="channel-post">

	<img src="${avatar}">
	<p><span class="channel-name">${name}</span> a posté un message :</p>
	<div class="social-message">${message}</div>

</div> */

/**
 * components/comment.js
 *
 * Comment component
 */

new Co({

	name: "comment",

	render: function($) {

		if (!$.data) {

			return;

		}

		var comment = $.data;

		var commentDiv = new El("div.comment");

			var headDiv = commentDiv.add(new El("div.comment-head"));

				var userDiv = headDiv.add(new El("div.user"));

					var avatar = userDiv.add(new El("img"));
					avatar.src = _my_avatar_;

					var a = userDiv.add(new El("a"));
					a.href  = "../channel/" + comment.channelUrl;
					a.innerHTML = comment.author;

				var dateDiv = headDiv.add(new El("div.date"));

					var p = dateDiv.add(new El("p"));
					p.innerHTML = comment.date;

			var textDiv = commentDiv.add(new El("div.comment-text"));

				var p1 = textDiv.add(new El("p"));
				p1.innerHTML = comment.comment;

			var noteDiv = commentDiv.add(new El("div.comment-notation"));

				var ul = noteDiv.add(new El("ul"));

					var li1 = ul.add(new El("li.plus"));
					var li2 = ul.add(new El("li.moins"));

					li1.id = "plus-" + comment.id;
					li2.id = "moins-" + comment.id;

					li1.onclick = function(commentId) {

						return function() {

							likeComment(commentId);

						}

					}(comment.id);

					li2.onclick = function(commentId) {

						return function() {

							dislikeComment(commentId)

						}

					}(comment.id);

					li1.innerHTML = "+" + comment.plusNumber;
					li2.innerHTML = "-" + comment.moinsNumber;

		return commentDiv;
	
	}

});

/**
 * components/ripple.js
 *
 * Ripple component
 */

new Component({

	name: "ripple",

	render: function($) {

		var ripple = new Element("div.ripple");
	
		if ($.parent) {

			var event = "ontouchstart" in window ? "touchstart" : "mousedown";
	
			El($.parent).on(event, function(event, elements) {
	
				var ripple = elements.ripple,
					parent = elements.parent;

				if (!El(parent).hasClass("disabled")) {
	
					var circle = ripple.add(new El("div.ripple__circle.ripple__circle--animate"));
	
					var parentOffset = El(parent).offset();
	
					var clickX = event.changedTouches ? event.changedTouches[0].pageX : event.pageX,
						clickY = event.changedTouches ? event.changedTouches[0].pageY : event.pageY;
	
					circle.style.left = clickX - parentOffset.x + "px";
					circle.style.top = clickY - parentOffset.y + "px";
	
				}
	
			}, {
	
				ripple: ripple,
				parent: $.parent
	
			});
	
		}

		return ripple;
	
	}

});

/* TEMPLATE

<ripple parent="${parent-node}"/> */

/**
 * Scripts/add-playlist.js
 *
 * ADD VIDEO TO PLAYLIST
 */

function initPlaylistCheckbox(checkbox) {

	El(checkbox).on("change", function(checkbox) {
	
		return function() {
	
			if (checkbox.checked) {

				addVideoToPlaylist(checkbox.getAttribute("data-playlist-id"), _VIDEO_ID_);

			}

			else {

				removeVideoFromPlaylist(checkbox.getAttribute("data-playlist-id"), _VIDEO_ID_);

			}
	
		};
	
	}(checkbox));

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#add-playlist-icon")) {

			return false;

		}

		El("#add-playlist-icon").onclick = function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("playlist")) {

				videoInfoDescription.removeClass("export");
				videoInfoDescription.removeClass("playlist");

			}

			else {

				videoInfoDescription.removeClass("export");
				videoInfoDescription.addClass("playlist");

			}

		};

		var childs = El("#playlist-add-form-list").childNodes;

		for (child in childs) {
		
			if (childs.hasOwnProperty(child)) {
		
				if (childs[child].nodeName === "INPUT") {

					initPlaylistCheckbox(childs[child]);

				}

			}
			
		}

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

new Script({

	call: function() {

		/*console.log(El(document.body).add(Co('<card vid-id="${vid_id}" title="${title}" thumbnail="${thumbnail}" duration="${duration}" views="${views}" channel="${channel}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			title: "Très le titre",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			duration: "12:18",
			views: "37",
			channel: "bla",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="plus" vid-id="${vid_id}" thumbnail="${thumbnail}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			thumbnail: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="comment" vid-id="${vid_id}" comment="${comment}" relative-time="${relative_time}" vid-name="${vid_name}" channel-name="${channel_name}"/>', {

			vid_id: "000000",
			comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi, laboriosam, nobis mollitia, autem similique atque repellendus beatae qui cum minima voluptas earum aliquid! Possimus aliquid delectus, illum laborum recusandae cum.",
			relative_time: "il y a 2 minutes",
			vid_name: "Nom",
			channel_name: "Bla"

		}))[0]);*/

		/*console.log(El(document.body).add(Co('<card type="channel" avatar="${avatar}" subscribers="${subscribers}" relative-time="${relative_time}" my-channel-name="${my_channel_name}" channel="${channel}" channel-name="${channel_name}"/>', {

			avatar: "//lorempicsum.com/up/255/200/2",
			relative_time: "il y a 2 minutes",
			subscribers: 13,
			my_channel_name: "Me",
			channel: "Bla",
			channel_name: "Bla"

		}))[0]);*/

	}

});
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



/**
 * scripts/comment.js
 *
 * COMMENT
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#post-comment-button")) {

			return false;

		}

		El("#post-comment-button").onclick = function() {

			postComment(El("#post-comment-button").getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value);

		};

	}

});

function postComment(vid, commentContent, fromChannel, parent) {

	marmottajax.post({

		url: "../comments/",

		options: {

			commentSubmit: "lol",
			"comment-content": commentContent,
			"from-channel": fromChannel,
			"video-id": vid,
			parent: parent

		}

	}).then(function(fromChannel) {

		return function(result) {

			var comment = JSON.parse(result);

			comment.channelUrl = fromChannel;
			comment.avatar = _my_avatar_;
			comment.plusNumber = 0;
			comment.moinsNumber = 0;
			comment.date = "À l'instant";

			El("#comments-best").addFirst(Co('<comment data="${data}"/>', { data: comment }));

		}

	}(fromChannel));

	El("#textarea-comment").value = "";

}

/**
 * scripts/playlist-scroll.js
 *
 * PLAYLIST SCROLL BUTTONS
 */

function playListScroll(data) {

    El("#playlist-videos").scrollLeft += data;

}

new Script({

    pages: ["watch"],

	call: function() {

        if (!document.getElementById("playlist-button-scroll-left")) {

            return false;

        }

		var buttonLeft = El("#playlist-button-scroll-left"),
            buttonRight = El("#playlist-button-scroll-right");

        buttonLeft.onclick = function() {

            playListScroll(-300);

        };

        buttonRight.onclick = function() {

            playListScroll(200);

        };

	}

});

/**
 * scripts/redirect-at-end.js
 * 
 * Redirect at the end of the video
 */

function redirectOverlayUpdate() {

	var redirectAtEnd = document.getElementById("redirect-at-end");

	redirectAtEnd.innerHTML = redirectAtEnd.getAttribute("data-message").replace("{time}", Application.redirectOverlayTime) + "<br>";

	var cancel = document.createElement("div");
	cancel.className = "video__redirect-at-end__cancel";
	cancel.innerHTML = redirectAtEnd.getAttribute("data-cancel-message");

	cancel.onclick = cancelRedirectOverlay;

	redirectAtEnd.appendChild(cancel);

};

function cancelRedirectOverlay() {

	var redirectAtEnd = document.getElementById("redirect-at-end");

	clearInterval(Application.redirectOverlayInterval);

	Application.redirectOverlayTime = 5;
	Application.redirectOverlay = false;

	redirectAtEnd.className = redirectAtEnd.className.replace("video__redirect-at-end--show", "");

};

new Script({

    pages: ["watch"],

	call: function() {

		var video = document.getElementById("video-tag");

		if (!video) {

		    return false;

		}

		Application.redirectOverlay = false;

		video.addEventListener("ended", function(event) {

			if (!Application.redirectOverlay) {

				Application.redirectOverlay = true;
				
				if (typeof _redirectAtEnd !== "undefined" && _redirectAtEnd !== "") {

					var redirectAtEnd = document.getElementById("redirect-at-end");

					Application.redirectOverlayTime = 5;

					redirectOverlayUpdate();

					if (redirectAtEnd.className.indexOf("video__redirect-at-end--show") < 0) {

						redirectAtEnd.className += " video__redirect-at-end--show";

					}

					if (Application.redirectOverlayInterval) {

						clearInterval(Application.redirectOverlayInterval);

						Application.redirectOverlayInterval = null;

					}

					Application.redirectOverlayInterval = setInterval(function() {

						Application.redirectOverlayTime --;

						redirectOverlayUpdate();

						if (Application.redirectOverlayTime === 0) {

							document.location = _redirectAtEnd;

						}

					}, 1000);

				}

			}
		
		}, false);

	}

});

/**
 * core/$.js
 *
 * DOM Content Loaded function
 */

Application.dom_load_event_listeners = [];

function $(callback) {

	if (typeof callback === "function") {

		Application.dom_load_event_listeners.push(callback);

	}

}

Application.dom_content_loaded = false;

Application.on_dom_content_loaded = function(event) {

	if (!Application.dom_content_loaded) {

		Application.dom_content_loaded = true;

		for (var i = 0; i < Application.dom_load_event_listeners.length; i++) {

			var fn = Application.dom_load_event_listeners[i]

			if (typeof fn === "function") {

				fn();

			}
			
		}

	}

};

El(document).on("DOMContentLoaded", Application.on_dom_content_loaded);
El(window).on("load", Application.on_dom_content_loaded);

window.onload = function() {

    Application.on_dom_content_loaded();

};

/**
 * Core/isset.js
 *
 * Test if a variable is not `undefined`
 */

function isset(variable) {

	return typeof variable !== "undefined";

}

/**
 * Core/scripts-launch.js
 *
 * SCRIPTS LAUNCH
 */

$(function() {

	for (var i = 0; i < Application.scripts.length; i++) {

		var can_call = false,
			script = Application.scripts[i];

		if (script.pages === "*" || script.pages === "all" || !script.pages) {

			can_call = true;

		}

		else {

			for (var p = 0; p < script.pages.length; p++) {
				
				if (script.pages[p] === _currentpage_) {

					can_call = true;

				}

			}
			
		}

		if (can_call) {

			script.call();

		}

	}

});

/**
 * Core/scripts.js
 *
 * MAIN SCRIPT SCRIPT
 */

Application.scripts = [];

var Script = function(script) {

	this.pages = script.pages;

	this.to_call = script.call;

	Application.scripts.push(this);

};

Script.prototype.call = function() {
	
	this.to_call();

};

/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function backgroundLoader(element) {

    this.element = El(element);
    this.src = this.element.getAttribute("data-background");;
    this.element.style.backgroundImage = "url(" + this.src + ")";

    this.imgLoader = new Image();
    this.imgLoader.src = this.src;

    El(this.imgLoader).on("load", function(event, element) {

        element.removeClass("bg-loader");

        element.addClass("bg-loader-transition");
        element.addClass("bg-loaded");

        setTimeout(function(element) {

            return function() {

                element.removeClass("bg-loader-transition");

            }

        }(element), 300);

    }, this.element);

 }

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bg-loader");

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new backgroundLoader(elements[i]);

		    }

		}

	}

});

/**
 * Scripts/test.js
 *
 * TEST SCRIPT
 */

function postMessage() {

 	marmottajax.post({

 		url: "../../../posts",
 		json: true,

 		options: {

 			"post-message-submit": "lol",
 			channel: El("#channel-social-message-submit").getAttribute("data-channel-id"),
 			"post-content": El("#post-content").value

 		}

 	}).then(function(channel) {

 		return function(result) {
	
 			El("#channel-posts").addFirst(Co('<channel-post avatar="${avatar}" channel="${channel}" message="${message}"/>', {
	
 				avatar: _my_avatar_,
 				channel: _my_pseudo_,
 				message: result.content
	
 			}));

 		}

 	}(El("#channel-social-message-submit").getAttribute("data-channel-id")));

 	El("#post-content").value = "";

}

new Script({

	pages: ["channel"],

	call: function() {

		var channelSocialMessageSubmit = El("#channel-social-message-submit");

		if (channelSocialMessageSubmit) {

			channelSocialMessageSubmit.onclick = postMessage;

			El("#post-content").on("keydown", function(event) {

			    if (event.keyCode === 13 && event.ctrlKey) {

			        postMessage();

			    }

			});

		}

	}

});

/**
 * Scripts/embed-video.js
 *
 * EMBED VIDEO
 */

function setExporterInputValue() {

	if (!document.getElementById("exporter-input")) {

		return false;

	}

	var exporterInput = El("#exporter-input"),

		exporterQuality = El("#exporter-quality"),
		exporterAutoplay = El("#exporter-autoplay"),
		exporterTimeCheckbox = El("#exporter-time-checkbox"),
		exporterTimeInput = El("#exporter-time-input");

	var url = "//dreamvids.fr/embed/" + _VIDEO_ID_;

	var quality = exporterQuality.options[exporterQuality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporterAutoplay.checked || false;

	if (autoplay) {

		url += "/autoplay";

	}

	var startAt = exporterTimeCheckbox.checked || false;

	if (startAt) {

		var timeUrlFormat = ["s", "m", "h"];

		var startTime = exporterTimeInput.value,
			times = startTime.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			/*url += i === 0 & !autoplay ? "?" : "&";

			url += timeUrlFormat[i] + "=" + times[i];*/

			url += times[i] + '/';

		}

	}

	exporterInput.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#embed-video-icon")) {

			return false;

		}

		El("#embed-video-icon").onclick = function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("export")) {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.removeClass("export");

			}

			else {

				videoInfoDescription.removeClass("playlist");
				videoInfoDescription.addClass("export");

				El("#exporter-input").select();

			}

		};

		El("#exporter-quality").on("change", setExporterInputValue),
		El("#exporter-autoplay").on("change", setExporterInputValue),
		El("#exporter-time-checkbox").on("change", setExporterInputValue),
		El("#exporter-time-input").on("change", setExporterInputValue);

		setExporterInputValue();

	}

});

/**
 * Scripts/model.js
 *
 * EXAMPLE SCRIPT
 */

new Script({

	pages: ["default", "watch"], // Pages

	// OU // pages: "all", // OU ne pas spécifier

	call: function() { // Fonction appelée lorsque la page peut être manipulée

		// console.log("Il pleut!", "{example script}");

	}

});

/**
 * Scripts/share-video.js
 *
 * SHARE
 */

new Script({

	pages: ["watch"],

	call: function() {

		if (!El("#share-video-icon")) {

			return false;

		}

		El("#share-video-icon").onclick = function() {

			var shareVideoBlock = El("#share-video-block"),
				videoInfoDescription = El("#video-info-description");

			shareVideoBlock.toggleClass("show");
			videoInfoDescription.toggleClass("little");

		};

	}

});