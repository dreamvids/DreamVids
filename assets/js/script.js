
/**
 * main.js
 *
 * Fichier JavaScript principal.
 */

var Application = {

	name: "MarmWork"

};
!function(win,doc){function on(element,event,callback,binding){if(!element.length)return"#document-fragment"===element.nodeName?void on(element.childNodes,event,callback,binding):("function"==typeof elAndCoEvents.list[event]?elAndCoEvents.list[event](element,function(){return function(event){"string"==typeof callback?eval(callback):callback(event,binding)}}(callback,binding)):isset(element.addEventListener)?element.addEventListener(event,function(){return function(a){callback(a,binding)}}(callback,binding),!1):element.attachEvent("on"+event,function(){return function(a){callback(a,binding)}}(callback,binding)),element);for(var i=0;i<element.length;i++)on(element[i],event,callback,binding)}function childNodeList(a){for(var b=[],c=0;c<a.childNodes.length;c++)if(b.push(a.childNodes[c]),a.childNodes[c].childNodes)for(var d=childNodeList(a.childNodes[c]),e=0;e<d.length;e++)b.push(d[e]);return b}function isset(a){return"undefined"!=typeof a}var window=win,document=doc,ELCO_MAX_COMPONENTS_GENERATED=2048,elAndCoEvents={list:{}};elAndCoEvents.add=function(a,b){elAndCoEvents.list[a]=b},elAndCoEvents.onClickEventsList=[],elAndCoEvents.add("CLICK",function(a,b){var c=new elAndCoEvents.onClickObject(a,b);elAndCoEvents.onClickEventsList.push(c)}),elAndCoEvents.onClickObject=function(a,b){this.callback=b,this.element=a,this.touchstart=function(a){return function(b){a.moved=!1,a.startX=b.touches[0].clientX,a.startY=b.touches[0].clientY}}(this),this.touchmove=function(a){return function(b){(Math.abs(b.touches[0].clientX-a.startX)>10||Math.abs(b.touches[0].clientY-a.startY)>10)&&(a.moved=!0)}}(this),this.touchend=function(a){return function(b){a.moved||a.callback(b)}}(this),on(this.element,"touchstart",this.touchstart),on(this.element,"touchmove",this.touchmove),on(this.element,"touchend",this.touchend),on(this.element,"touchcancel",this.touchend),on(this.element,"click",function(a,b){"ontouchstart"in window||b.callback(a)},this)};var El=Element=function(a,b){if(this!==window)var c=Element.create(a,b);else var c=Element.select(a,b);if(c)return c.childs=c.childNodes,c.parent=c.parentNode,c.clone=c.cloneNode,c.add=function(a){return function(b){if("#document-fragment"===b.nodeName){for(var c=[],d=b.childNodes,e=d.length,f=0;e>f;f++)a.appendChild(d[0]),c.push(a.childNodes[a.childNodes.length-1]);return c}if(!b.length)return a.appendChild(b),El(b);for(var f=0;f<b.length;f++){for(var c=[],e=b.length,f=0;e>f;f++)a.appendChild(b[0]),c.push(a.childNodes[a.childNodes.length-1]);return c}}}(c),c.addFirst=function(a){return function(b){if("#document-fragment"===b.nodeName){for(var c=[],d=b.childNodes,e=d.length,f=0;e>f;f++)a.insertBefore(d[0],a.firstChild),c.push(a.childNodes[a.childNodes.length-1]);return c}if(!b.length)return a.insertBefore(b,a.firstChild),El(b);for(var f=0;f<b.length;f++){for(var c=[],e=b.length,f=0;e>f;f++)a.insertBefore(b[0],a.firstChild),c.push(a.childNodes[a.childNodes.length-1]);return c}}}(c),c.on=function(a){return function(b,c,d){on(a,b,c,d)}}(c),c.offset=function(a){return function(){for(var b={x:0,y:0};a;)b.x+=a.offsetLeft-(a==document.body?0:a.scrollLeft)+a.clientLeft,b.y+=a.offsetTop-(a==document.body?0:a.scrollTop)+a.clientTop,a=a.offsetParent;return b}}(c),c.hasClass=function(a){return function(b){return(" "+a.className+" ").indexOf(" "+b+" ")>-1}}(c),c.addClass=function(a){return function(b){return El(a).hasClass(b)||(a.className+=" "+b),El(a)}}(c),c.removeClass=function(a){return function(b){return a.className=(" "+a.className+" ").replace(" "+b+" "," "),El(a)}}(c),c.toggleClass=function(a){return function(b){return El(a).hasClass(b)?El(a).removeClass(b):El(a).addClass(b),El(a)}}(c),c};Element.create=function(a,b){var c,d=/[-\w]+/.exec(a)[0];if(c=document.createElement(d),"object"==typeof b)for(attribute in b)b.hasOwnProperty(attribute)&&!c.getAttribute(attribute)&&c.setAttribute(attribute,b[attribute]);var e=a.replace(/#([a-z-_]+)/i,"").replace(/\w+/,"").split(".");if(e.length>1){c.className="";for(var f=1;f<e.length;f++)c.className+=" "+e[f]}var g=/([a-z-_]+)(#([a-z-_]+))/i.exec(a);return g&&(c.id=g[3]),c},Element.select=function(a){var b;return"string"!=typeof a?b=a:"#"==a[0]&&(b=document.getElementById(a.substring(1))),b};var Co=Component=function(a,b){if(this===window)return Co.generate(a,b);if(a.name&&(Co.components[a.name]=this,"object"==typeof a))for(variable in a)a.hasOwnProperty(variable)&&(isset(this[variable])||(this[variable]=a[variable]))};Co.components={},Component.attributesParser=function(a,b){for(var c={},d=0;d<a.length;d++)if(c[a[d].name]=a[d].value,"string"==typeof a[d].value&&"$"==a[d].value[0]&&b)for(parameter in b)a[d].value==="${"+parameter+"}"&&b.hasOwnProperty(parameter)&&(c[a[d].name]=b[parameter]);return c},Component.prototype.create=function(a){var b=this.render(a),c=childNodeList(b);if(isset(a._CHILDNODES_)&&a._CHILDNODES_.length){for(var d=!1,e=0;e<c.length;e++){var f=c[e];if("_inner_"===f.getAttribute("tag-name")){for(;a._CHILDNODES_.length;)f.parentNode.insertBefore(a._CHILDNODES_[0],f);f.parentNode.removeChild(f),d=!0;break}}if(!d)for(;a._CHILDNODES_.length;)b.appendChild(a._CHILDNODES_[0])}return isset(this.created)&&this.created(b),b},Component.generate=function(a,b){if("string"!=typeof a)return document.createElement("div");a=a.replace(/^\s+|\s+$/g,""),a=a.replace(/<([-\w]*)( (.+?))?\/>/g,"<$1$2></$1>"),a=a.replace(/<([-\w]*)( (.+?))?>/g,'<div tag-name="$1"$2>').replace(/<\/(.+?)>/g,"</div>");var c=document.createElement("div");c.innerHTML=a;var d=!1,e=!1;for(componentsCreated=0;!d;){e=!1,ELCO_MAX_COMPONENTS_GENERATED&&componentsCreated>ELCO_MAX_COMPONENTS_GENERATED&&(console.error("el & co erreur 001\nUne boucle de création de components a été détectée.\nLa génération des components a alors été arrêtée."),d=!0);for(var f=childNodeList(c),g=0;g<f.length;g++){var h=f[g],i="";if(h.getAttribute&&(i=h.getAttribute("tag-name")||""),Co.components[i]){var j=Component.attributesParser(h.attributes,b);j._CHILDNODES_=h.childNodes;var k=Co.components[i].create(j);for(attribute in j)j.hasOwnProperty(attribute)&&null===k.getAttribute(attribute)&&"string"==typeof j[attribute]&&k.setAttribute(attribute,j[attribute]);k.removeAttribute("tag-name"),h.parentNode.insertBefore(k,h),h.parentNode.removeChild(h),e=!0,componentsCreated++;break}}e||(d=!0)}return c.childNodes},Component.inner=function(a){var b=document.createElement("div");return b.setAttribute("tag-name","_inner_"),a.appendChild(b),a},window.Co=window.Component,window.El=window.Element,window.ELCO_MAX_COMPONENTS_GENERATED=ELCO_MAX_COMPONENTS_GENERATED}(window,document);

/*
 *  Marmottajax 1.0.4
 *  Envoyer et recevoir des informations simplement en JavaScript
 */

var marmottajax = function(options) {

    return marmottajax.get(options);

};

marmottajax.normalize = function(parameters) {

    return parameters ? typeof parameters === "string" ? { url: parameters } : parameters : null;

};

marmottajax.json = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.json = true;

        return new marmottajax.request(parameters);

    }

};

marmottajax.get = function(options) {

    return new marmottajax.request(options);

};

marmottajax.post = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "POST";

        return new marmottajax.request(parameters);

    }

};

marmottajax.put = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "PUT";

        return new marmottajax.request(parameters);

    }

};

marmottajax.destroy = marmottajax.remove = marmottajax.delete_ = function(parameters) {

    if (parameters = marmottajax.normalize(parameters)) {

        parameters.method = "DELETE";

        return new marmottajax.request(parameters);

    }

};

marmottajax.request = function(options) {

    if (!options) { return false; }

    if (typeof options === "string") {

        options = { url: options };

    }

    if (options.method === "POST" || options.method === "PUT" || options.method === "DELETE") {

        var post = "?";

        for (var key in options.options) {

            post += options.options.hasOwnProperty(key) ? "&" + key + "=" + options.options[key] : "";

        }

    }

    else {

        options.method = "GET";

        options.url += options.url.indexOf("?") < 0 ? "?" : "";

        for (var key in options.options) {

            options.url += options.options.hasOwnProperty(key) ? "&" + key + "=" + options.options[key] : "";

        }

    }

    this.xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");

    this.xhr.options = options;

    this.xhr.callbacks = {

        then: [],
        error: []

    };

    this.then = function(callback) {

        this.xhr.callbacks.then.push(callback);

        return this;

    };

    this.error = function(callback) {

        this.xhr.callbacks.error.push(callback);

        return this;

    };

    this.xhr.call = function(categorie, result) {

        for (var i = 0; i < this.callbacks[categorie].length; i++) {

            if (typeof(this.callbacks[categorie][i]) === "function") {

                this.callbacks[categorie][i](result);

            }

        }

    };

    this.xhr.onreadystatechange = function() {

        if (this.readyState === 4 && this.status == 200) {

            var result = this.responseText;

            if (this.options.json) {

                try {

                    result = JSON.parse(result);

                }

                catch (error) {

                    this.call("error", "invalid json");

                    return false;

                }

            }

            this.call("then", result);

        }

        else if (this.readyState === 4 && this.status == 404) {

            this.call("error", "404");

        }

        else if (this.readyState === 4) {

            this.call("error", "unknow");

        }

    };

    this.xhr.open(options.method, options.url, true);
    this.xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    this.xhr.send(typeof post != "undefined" ? post : null);

};

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

					li1.on("CLICK", function(event, commentId) {

						likeComment(commentId);

					}, comment.id);

					li2.on("CLICK", function(event, commentId) {

						dislikeComment(commentId)

					}, comment.id),

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

		El("#channel-social-message-submit").on("click", postMessage);

		El("#post-content").on("keydown", function(event) {

		    if (event.keyCode === 13 && event.ctrlKey) {

		        postMessage();

		    }

		});

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

		DEBUG(["comment Script called", 'El("#post-comment-button") :', El("#post-comment-button").nodeName]);

		if (!El("#post-comment-button")) {

			return false;

		}

		var postCommentButton = El("#post-comment-button");

		postCommentButton.on("CLICK", function(event, postCommentButton) {

			DEBUG(["postCommentButton clicked", event, postCommentButton]);
			DEBUG(["postComment", postComment]);
			DEBUG([postCommentButton.getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value]);

			postComment(postCommentButton.getAttribute("data-vid-id"), El("#textarea-comment").value, El("#channel-selector").value, El("#parent-comment").value);

		}, postCommentButton);

	}

});

function postComment(vid, commentContent, fromChannel, parent) {

	DEBUG(["postComment called", {

		vid: vid,
		commentContent: commentContent,
		fromChannel: fromChannel,
		parent: parent

	}]);

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
 * Scripts/embed-video.js
 *
 * SHARE
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

		El("#embed-video-icon").on("CLICK", function() {

			var videoInfoDescription = El("#video-info-description");

			if (videoInfoDescription.hasClass("export")) {

				videoInfoDescription.removeClass("export");

			}

			else {

				videoInfoDescription.addClass("export");

				El("#exporter-input").select();

			}

		});

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

		buttonLeft.on("CLICK", function(event, elements) {

            var buttonLeft = El("#playlist-button-scroll-left"),
                buttonRight = El("#playlist-button-scroll-right"),
                playlistVideos = El("#playlist-videos");

            playListScroll(-300);

        });

        buttonRight.on("CLICK", function(event, elements) {

            var buttonLeft = El("#playlist-button-scroll-left"),
                buttonRight = El("#playlist-button-scroll-right"),
                playlistVideos = El("#playlist-videos");

            playListScroll(200);

        });

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

		var shareVideoIcon = El("#share-video-icon");

		/*shareVideoIcon.on("CLICK", function() {

			var shareVideoBlock = El("#share-video-block"),
				videoInfoDescription = El("#video-info-description");

			shareVideoBlock.toggleClass("show");
			videoInfoDescription.toggleClass("little");

		});*/

		shareVideoIcon.addEventListener("click", function() {

			var shareVideoBlock = El("#share-video-block"),
				videoInfoDescription = El("#video-info-description");

			shareVideoBlock.toggleClass("show");
			videoInfoDescription.toggleClass("little");
			
		}, false);

	}

});