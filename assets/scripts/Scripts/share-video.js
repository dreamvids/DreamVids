
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