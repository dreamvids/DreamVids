
/**
 * Scripts/add-playlist.js
 *
 * ADD VIDEO TO PLAYLIST
 */

function createPlaylistEvent() {

	createPlaylist(El("#playlist-create-input").value, function(name, id) {

		var newPlayListCheckbox = El("#playlist-add-form-list").add(new El("input"));
		newPlayListCheckbox.type = "checkbox";
		newPlayListCheckbox.setAttribute("data-playlist-id", id);
		newPlayListCheckbox.id = "playlist-add-checkbox-" + id;

		var newPlayListCheckboxLabel = El("#playlist-add-form-list").add(new El("label"));
		newPlayListCheckboxLabel.for = "playlist-add-checkbox-" + id;
		newPlayListCheckboxLabel.innerHTML = name;

		El("#playlist-add-form-list").add(new El("br"));

		initPlaylistCheckbox(newPlayListCheckbox);

	});

	El("#playlist-create-input").value = "";

}

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

		El("#playlist-create-button").onclick = createPlaylistEvent;

		El("#playlist-create-input").on("keyup", function(event) {

			if(event.keyCode == 13) {

				createPlaylistEvent();

			}

		});

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