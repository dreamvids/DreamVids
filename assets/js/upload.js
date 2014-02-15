
var fileField = $('videoFile');

fileField.addEventListener("change", onFileFieldChangeEvent, true);

function uploadVideo() {
	var file = $('videoFile').files[0];
	var formData = new FormData();

	$('progress-bar').value = 0;

	formData.append('videoFile', file);

	var request = new XMLHttpRequest();
	request.upload.addEventListener("progress", onProgressEvent, false);
	request.addEventListener("load", onCompleteEvent, false);
	request.addEventListener("error", onErrorEvent, false);
	request.addEventListener("abort", onAbortEvent, false);

	request.open('POST', 'upload/process/');
	request.send(formData);
}

function onFileFieldChangeEvent(event) {
	fileField.setAttribute('disabled', '');
	var preProcessRequest = new XMLHttpRequest();
	preProcessRequest.open('GET', 'upload/preprocess/');
	preProcessRequest.send(null);

	uploadVideo();
}

function onProgressEvent(event) {
	var percent = 100 * (event.loaded / event.total);

	$('progress-bar').value = percent;
	$('status').innerHTML = percent + '% of the video file uploaded';
	$('bytesLoaded').innerHTML = event.loaded + " of " + event.total + " byes loaded !";
}

function onCompleteEvent(event) {
	$('status').innerHTML = 'Upload done !';
	$('progress-bar').value = 100;
}

function onErrorEvent(event) {
	$('status').innerHTML = 'Video upload failed';
	$('progress-bar').value = 0;
}

function onAbortEvent(event) {
	$('status').innerHTML = 'Video upload cancelled';
	$('progress-bar').value = 0;
}

function $(element) {
	return document.getElementById(element); 
}