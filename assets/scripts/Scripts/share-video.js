
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