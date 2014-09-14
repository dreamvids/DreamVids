
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