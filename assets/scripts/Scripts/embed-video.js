
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