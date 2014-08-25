
/**
 * Scripts/embed-video.js
 *
 * SHARE
 */

function set_exporter_input_value() {

	if (!document.getElementById("exporter-input")) {

		return false;

	}

	var exporter_input = El("#exporter-input"),

		exporter_quality = El("#exporter-quality"),
		exporter_autoplay = El("#exporter-autoplay"),
		exporter_time_checkbox = El("#exporter-time-checkbox"),
		exporter_time_input = El("#exporter-time-input");

	var url = "//dreamvids.fr/embed/" + _VIDEO_ID_;

	var quality = exporter_quality.options[exporter_quality.value].innerHTML || "640x360",
		qualitys = quality.split("x");
		width = qualitys[0],
		height = qualitys[1];

	var autoplay = exporter_autoplay.checked || false;

	if (autoplay) {

		url += "/autoplay";

	}

	var start_at = exporter_time_checkbox.checked || false;

	if (start_at) {

		var time_url_format = ["s", "m", "h"];

		var start_time = exporter_time_input.value,
			times = start_time.split(":").reverse();

		for (var i = 0; i < times.length; i++) {

			/*url += i === 0 & !autoplay ? "?" : "&";

			url += time_url_format[i] + "=" + times[i];*/

			url += times[i] + '/';

		}

	}

	exporter_input.value = "<iframe width=\"" + width + "\" height=\"" + height + "\" src=\"" + url + "\" allowfullscreen frameborder=\"0\"></iframe>";

}

new Script({

	pages: ["watch"],

	call: function() {

		if (!document.getElementById("embed-video-icon")) {

			return false;

		}

		var embed_video_icon = El("#embed-video-icon");

		on(embed_video_icon, "CLICK", function() {

			var video_info_description = El("#video-info-description");

			if (video_info_description.has_class("export")) {

				video_info_description.remove_class("export");

			}

			else {

				video_info_description.add_class("export");

				El("#exporter-input").select();

			}

		});

		El("#exporter-quality").on("change", set_exporter_input_value),
		El("#exporter-autoplay").on("change", set_exporter_input_value),
		El("#exporter-time-checkbox").on("change", set_exporter_input_value),
		El("#exporter-time-input").on("change", set_exporter_input_value);

		set_exporter_input_value();

	}

});