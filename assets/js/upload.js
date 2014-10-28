var uploader = document.getElementById("uploader");
var uploadInput = document.getElementById("upload-input");
var uploadForm = document.getElementById("upload-form");
var fileName = document.getElementById("file-name");
var progressBar = document.getElementById("progress-bar");
var disablingCode = function() {
	alert('Veuillez attendre la fin de la mise en ligne de la vidéo');
	return false;
};
uploadForm.onsubmit = disablingCode;

var timeUpload = {

	started: 0,
	current: 0

};

function cancelUpload() {

	if (!uploadHttpRequest)
		return false;

	uploadHttpRequest.abort();
	uploadInput.removeAttribute("disabled");

}

function tempsRestant(timestamp) {

	var seconds = Math.round(timestamp / 1000);
	var minutes = Math.round(seconds / 60);
	var heures = Math.round(minutes / 60);

	if (seconds < 1)
		return "bientôt";
	else if (seconds < 60)
		return seconds + " secondes";
	else if (minutes === 1)
		return minutes + " une minute";
	else if (minutes < 14)
		return minutes + " minutes";
	else if (minutes < 16)
		return "un quart d'heures";
	else if (minutes < 29)
		return minutes + " minutes";
	else if (minutes < 31)
		return "une demi heure";
	else if (minutes < 55)
		return minutes + " minutes";
	else if (minutes < 65)
		return "une heure";
	else if (minutes < 120)
		return "une heure";
	else if (minutes < 1440)
		return heures + " heures";
	else
		return "très longtemps";

}

/*function submitVideoInfo() {

	var title = document.getElementById("video-title").value;
	var description = document.getElementById("video-description").value;
	var tags = document.getElementById("video-tags").value;
	var thumb = document.getElementById("video-tumbnail").files[0];
	var visibility = document.getElementById("video-visibility").value;

	marmottajax.post("../upload/", {

		videoTitle: title,
		videoDescription: description,
		videoTags:tags,
		videoVisibility: visibility

	}).then(function(result) {
		
		console.log("POST upload/", result);
	
	});

	var postRequest = new XMLHttpRequest();
	postRequest.open("POST", "upload/addthumb");

	var thumbForm = new FormData();
	thumbForm.append("videoThumbnail", document.getElementById("video-tumbnail").files[0]);

	postRequest.send(thumbForm);

}*/

uploadInput.addEventListener("change", function(event) {

	var extension = uploadInput.value.split(".")[uploadInput.value.split(".").length - 1].toLowerCase();
	var validsExtensions = ["webm", "mp4", "m4a", "mpg", "mpeg", "3gp", "3g2", "asf", "wma", "mov", "avi", "wmv", "ogg", "ogv", "flv", "mkv"];

	if (validsExtensions.indexOf(extension) != -1) {

		uploader.className = uploader.className.replace(" hover", "");
		uploader.className = "uploading";

		var name = uploadInput.files[0].name.replace(/\.[0-9a-z]+$/i, "");
		fileName.innerHTML = name;

		if (document.getElementById("video-title").value == "") {

			document.getElementById("video-title").value = name;

		}

		uploadInput.setAttribute("disabled", "true");
		document.getElementById("up-submit").removeAttribute("disabled");

		uploadHttpRequest = new XMLHttpRequest();
		uploadHttpRequest.open("POST", _webroot_+"videos");

		uploadHttpRequest.upload.onprogress = function(event) {

			timeUpload.current = new Date().getTime();
			var totalTime = (timeUpload.current - timeUpload.started) * event.total / event.loaded
			time = totalTime - (timeUpload.current - timeUpload.started);

			restant = tempsRestant(time);

			progressBar.dataset["restant"] = restant;

			percent = Math.round((event.loaded / event.total) * 100);
			progressBar.style.width = progressBar.dataset["percent"] = percent + "%";

			document.title = percent != 100 ? percent + "% | " + restant + " restant" : "Upload terminé";

		};

		uploadHttpRequest.onload = function() {

			uploader.className = "uploaded";
			progressBar.style.width = "100%";
			progressBar.dataset["restant"] = "";
			uploadForm.onsubmit = function(){return true};

			console.log("POST /videos", uploadHttpRequest.responseText);

		};

		var form = new FormData();
		form.append("video", uploadInput.files[0]);
		form.append("channelId", document.getElementById('channelId').value);
		form.append("uploadId", document.getElementById('uploadId').value);

		uploadHttpRequest.send(form);
		timeUpload.started = new Date().getTime();

	}

	else {

		alert("Type de fichier incorrect");

	}

}, false);