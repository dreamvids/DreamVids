
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

			if (videoInfoDescription.hasClass("little")) {

				videoInfoDescription.removeClass("little");

			}

			else {

				videoInfoDescription.className += " little";

			}

			if (shareVideoBlock.hasClass("show")) {

				shareVideoBlock.removeClass("show");

			}

			else {

				shareVideoBlock.className += " show";

			}

		};

	}

});