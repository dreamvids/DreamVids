
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