
/**
 * Core/main.js
 *
 * MAIN CORE FILE
 */

var Application = {};

var _scripts_ = [];

var Script = function(script) {

	this.pages = script.pages;

	this.to_call = script.call;

	_scripts_.push(this);

};

Script.prototype.call = function() {
	
	this.to_call();

};
var marmottajax=function(a){return marmottajax.get(a)};marmottajax.n=function(a){return a?"string"==typeof a?{url:a}:a:!1},marmottajax.json=function(a){return(a=marmottajax.n(a))?(a.json=!0,new marmottajax.r(a)):void 0},marmottajax.get=function(a){return new marmottajax.r(a)},marmottajax.post=function(a){return(a=marmottajax.n(a))?(a.method="POST",new marmottajax.r(a)):void 0},marmottajax.r=function(a){if(!a)return!1;if("string"==typeof a&&(a={url:a}),"POST"===a.method){var b="?";for(var c in a.options)b+=a.options.hasOwnProperty(c)?"&"+c+"="+a.options[c]:""}else{a.method="GET",a.url+=a.url.indexOf("?")<0?"?":"";for(var c in a.options)a.url+=a.options.hasOwnProperty(c)?"&"+c+"="+a.options[c]:""}this.x=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP"),this.x.o=a,this.x.c={t:[],e:[]},this.then=function(a){return this.x.c.t.push(a),this},this.error=function(a){return this.x.c.e.push(a),this},this.x.l=function(a,b){for(var c=0;c<this.c[a].length;c++)"function"==typeof this.c[a][c]&&this.c[a][c](b)},this.x.y=function(a){this.l("t",a)},this.x.z=function(a){this.l("e",a)},this.x.onreadystatechange=function(){if(4===this.readyState&&200==this.status){var a=this.responseText;if(this.o.json)try{a=JSON.parse(a)}catch(b){return this.z("invalid json"),!1}this.y(a)}else 4===this.readyState&&404==this.status?this.z("404"):4===this.readyState&&this.z("unknow")},this.x.open(a.method,a.url,!0),this.x.setRequestHeader("Content-type","application/x-www-form-urlencoded"),this.x.send("undefined"!=typeof b?b:null)};

/**
 * Utils/on.js
 *
 * EVENT LISTENER
 */

function on(element, event, callback) {

	if (event === "CLICK") {

		Application.onTap(element, callback);

	}

	else {

		if (element.addEventListener) {

			element.addEventListener(event, callback, false);

		}

		else {

			element.attachEvent(event, callback);
			
		}

	}

	return element;

}

/**
 * Utils/tap.js
 *
 * TAP EVENT
 */

Application.onTapEventsList = [];

Application.onTap = function(element, callback) {

	var eventListener = new Application.onTapObject(element, callback);
	
	Application.onTapEventsList.push(eventListener);

};

Application.onTapObject = function(element, callback) {

	this.callback = callback;
	this.element = element;

	this.touchstart = function(eventListener) {

		return function(event) {

			eventListener.moved = false;

			eventListener.startX = event.touches[0].clientX;
			eventListener.startY = event.touches[0].clientY;

		}

	}(this);

	this.touchmove = function(eventListener) {

		return function(event) {

			if (Math.abs(event.touches[0].clientX - eventListener.startX) > 10 || Math.abs(event.touches[0].clientY - eventListener.startY) > 10) {
			    
			    eventListener.moved = true;

			}

		}

	}(this);

	this.touchend = function(eventListener) {

		return function(event) {

			if (!eventListener.moved) {

				eventListener.callback(event);

			}

		}

	}(this);

	on(this.element, "touchstart", this.touchstart);
	on(this.element, "touchmove", this.touchmove);
	on(this.element, "touchend", this.touchend);
	on(this.element, "touchcancel", this.touchend);

	on(this.element, "click", function(eventListener) {

		return function() {

	        if (!("ontouchstart" in window)) {

	            eventListener.callback(event);

	        }

	    };

	}(this));

};

/**
 * Core/launch.js
 *
 * CORE LAUNCH
 */

document.addEventListener("DOMContentLoaded", function() {

	for (var i = 0; i < _scripts_.length; i++) {

		var can_call = false,
			script = _scripts_[i];

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

}, false);

/**
 * Scripts/bg-loader.js
 *
 * BACKGROUND LOADER
 */

function background_loader(element) {

     this.element = element;
     this.src = this.element.getAttribute("data-background");;
     this.element.style.backgroundImage = "url(" + this.src + ")";

     this.imgLoader = new Image();
     this.imgLoader.src = this.src;

     on(this.imgLoader, "load", function(event) {

         element.className = element.className.replace("bgLoader", "");
         element.className = element.className.replace("bg-loader", "");

         element.className += " bgLoaderTransition bgLoaded";
         element.className += " bg-loader-transition bg-loaded";

         setTimeout(function(element) {

             return function() {

                 element.className = element.className.replace("bg-loader-transition", "");

             }

         }(element), 300);

     });

 }

new Script({

	call: function() {

		var elements = document.getElementsByClassName("bgLoader");

		if (elements.length) {

			console.error(elements.length + " éléments possedent la classe bgLoader qui n'est plus utilisée.");

		}

		var new_class_elements = document.getElementsByClassName("bg-loader");

		for (var i = 0; i < new_class_elements.length; i++) {

			elements.push(new_class_elements[i]);
			
		}

		if (elements && elements.length) {

		    for (var i = 0, length = elements.length; i < length; i++) {

		        new background_loader(elements[i]);

		    }

		}

	}

});

/**
 * Scripts/embed-video.js
 *
 * SHARE
 */

function set_exporter_input_value() {

	var exporter_input = document.getElementById("exporter-input") || document.createElement("div"),

		exporter_quality = document.getElementById("exporter-quality") || document.createElement("div"),
		exporter_autoplay = document.getElementById("exporter-autoplay") || document.createElement("div"),
		exporter_time_checkbox = document.getElementById("exporter-time-checkbox") || document.createElement("div"),
		exporter_time_input = document.getElementById("exporter-time-input") || document.createElement("div");

	var url = "//dreamvids.fr/embed/" + _VIDEO_ID_;

	var quality = exporter_quality.options[exporter_quality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporter_autoplay.checked || false;

	if (autoplay) {

		url += "?autoplay";

	}

	var start_at = exporter_time_checkbox.checked || false;

	if (start_at) {

		var time_url_format = ["s", "m", "h"];

		var start_time = exporter_time_input.value,
			times = start_time.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			url += i === 0 & !autoplay ? "?" : "&";

			url += time_url_format[i] + "=" + times[i];

		}

	}

	exporter_input.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		var embed_video_icon = document.getElementById("embed-video-icon") || document.createElement("div");

		on(embed_video_icon, "CLICK", function() {

			var video_info_description = document.getElementById("video-info-description") || document.createElement("div");

			if (video_info_description.className.search("export") > -1) {

				video_info_description.className = video_info_description.className.replace("export", "");

			}

			else {

				video_info_description.className += " export";

				var exporter_input = document.getElementById("exporter-input") || document.createElement("div");

				exporter_input.select();

			}

		});

		var exporter_input = document.getElementById("exporter-input") || document.createElement("div"),

			exporter_quality = document.getElementById("exporter-quality") || document.createElement("div"),
			exporter_autoplay = document.getElementById("exporter-autoplay") || document.createElement("div"),
			exporter_time_checkbox = document.getElementById("exporter-time-checkbox") || document.createElement("div"),
			exporter_time_input = document.getElementById("exporter-time-input") || document.createElement("div");

		on(exporter_quality, "change", set_exporter_input_value);
		on(exporter_autoplay, "change", set_exporter_input_value);
		on(exporter_time_checkbox, "change", set_exporter_input_value);
		on(exporter_time_input, "change", set_exporter_input_value);

		set_exporter_input_value();

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

		var share_video_icon = document.getElementById("share-video-icon") || document.createElement("div");

		on(share_video_icon, "CLICK", function() {

			var share_video_block = document.getElementById("share-video-block") || document.createElement("div"),
				video_info_description = document.getElementById("video-info-description") || document.createElement("div");

			if (share_video_block.className.search("show") > -1) {

				share_video_block.className = share_video_block.className.replace("show", "");
				video_info_description.className = video_info_description.className.replace("little", "");

			}

			else {

				share_video_block.className += " show";
				video_info_description.className += " little";

			}

		});

	}

});