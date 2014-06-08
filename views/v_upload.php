<div id="upload-large-modal">
	<div class="bgLoader" id="backgroundLoader" data-background="img/backgrounds/002.jpg"></div>

	<section id="message-upload">
		
		<?php

			if (isset($err)) {

				echo "<h3>" . $lang['error'] . ": " . $err . "</h3>";

			}

			else if (!isset($err) && isset($_POST['submit'])) {

				echo "<h3>" . $uploadDone . "</h3>";

			}

			else { ?>
				
				<h3>Déposez votre fichier vidéo dans cette zone pour l'uploader</h3>
				<p>(Pour selectionner votre fichier manuellement cliquez sur le nuage)</p>

			<?php } ?>

	</section>

	<section id="uploader">
		<span id="upload-illustration">
			<span class="cloud">
				<span id="arrowUpload" data-uploaded-message="Uploaded"></span>
			</span>
		</span>

		<input id="videoInput" type="file" name="video" accept="video/*" name="videoInput">

		<div id="file-name"></div>
	</section>

	<div id="progress-upload">
		<div id="progress-bar"></div>
	</div>
</div>

<div id="upload-content">
	<form class="form middle" method="post" action="" enctype="multipart/form-data">
		<label for="videoTitle">
			<?php echo $lang['title']; ?> :
			<input id="videoTitle" type="text" name="videoTitle" placeholder="Titre" spellcheck="false"/>
		</label>
		
		<label for="videoDescription">
			<?php echo $lang['desc']; ?> :
			<textarea name="videoDescription" id="videoDescription" rows="4" placeholder="Description"></textarea>
		</label>
		
		<label for="videoTags">
			<?php echo $lang['tags']; ?> :<input id="videoTags" type="text" name="videoTags" placeholder="Tags" spellcheck="false"/>
		</label>

		<label for="videoTumbnail">
			<img class="preview none filePreview" data-input="videoTumbnail" id="preview-upload-thumbnail">
			<i><?php echo $lang['tumbnail']; ?> :</i>
			<input type="file" data-text="Choisir un fichier" data-preview="preview-upload-thumbnail" name="videoTumbnail" id="videoTumbnail" accept="image/*"><br>
		</label>
		
		<label for="videoVisibility"><?php echo $lang['visibility']; ?> :</label>	
		<select name="videoVisibility" id="videoVisibility">
			<option value="2"><?php echo $lang['public']; ?></option>
			<option value="1"><?php echo $lang['non_listed']; ?></option>
			<option value="0"><?php echo $lang['private']; ?></option>
		</select>
		
		<input type="submit" id="up-submit" disabled name="submit" value="Valider">
	</form>
</div>

<script>

var uploadHttpRequest;
	
var uploader = document.getElementById('uploader'),
	uploadInput = document.getElementById('videoInput'),
	fileName = document.getElementById('file-name'),
	progressBar = document.getElementById('progress-bar');

var timeUpload = {
    started: 0,
    current: 0
};

function cancelUpload() {
    if (!uploadHttpRequest)
        return false;

    uploadHttpRequest.abort();
    uploadInput.removeAttribute('disabled');
}

function tempsRestant(timestamp) {
    var seconds = Math.round(timestamp / 1000);
    var minutes = Math.round(seconds / 60);
    var heures = Math.round(minutes / 60);

    if (seconds < 1) { return "une seconde"; }
    else if (seconds < 60) { return seconds + " secondes"; }
    else if (minutes === 1) { return minutes + " une minute"; }
    else if (minutes < 14) { return minutes + " minutes"; }
    else if (minutes < 16) { return "un quart d'heures"; }
    else if (minutes < 29) { return minutes + " minutes"; }
    else if (minutes < 31) { return "une demi heure"; }
    else if (minutes < 55) { return minutes + " minutes"; }
    else if (minutes < 65) { return "une heure"; }
    else if (minutes < 120) { return "une heure"; }
    else if (minutes < 1440) { return heures + " heures"; }
    else { return "très longtemps"; }
}

uploadInput.addEventListener('change', function(event) {

    var extension = uploadInput.value.split('.')[uploadInput.value.split('.').length - 1].toLowerCase();
    var validsExtensions = ['webm', 'mp4', 'mov', 'avi', 'wmv', 'ogg', 'ogv'];

    if (validsExtensions.indexOf(extension) != -1) {

        document.body.onbeforeunload = function() {
            return "Si vous quittez la page, l'upload sera annulé";
        };

        uploader.className = uploader.className.replace(' hover', '');
        uploader.className = 'uploading';

        var name = uploadInput.files[0].name.replace(/\.[0-9a-z]+$/i, '');
        fileName.innerHTML = name;
        if (document.getElementById('videoTitle').value == '') {
            document.getElementById('videoTitle').value = name;
        }

        uploadInput.setAttribute('disabled', '');

        var uploadHttpRequest = new XMLHttpRequest();
        uploadHttpRequest.open("POST", 'index.php?page=upload');

        uploadHttpRequest.upload.onprogress = function(event) {

        	if (uploader.className != 'uploaded') {

            	timeUpload.current = new Date().getTime();
            	var totalTime = (timeUpload.current - timeUpload.started) * event.total / event.loaded
            	time = totalTime - (timeUpload.current - timeUpload.started);
	
            	restant = tempsRestant(time);
	
            	progressBar.dataset['restant'] = restant;
	
            	percent = Math.round((event.loaded / event.total) * 100);
            	progressBar.style.width = progressBar.dataset['percent'] = percent + '%';
	
            	document.title = percent + '% | ' + restant + " restant";
	
        	}

        };

        uploadHttpRequest.upload.onload = function(event) {

            uploader.className = 'uploaded';
            progressBar.style.width = '100%';
            progressBar.dataset['restant'] = "Terminé";
            document.title = 'Upload terminé';
            document.getElementById('up-submit').removeAttribute('disabled');
            document.body.onbeforeunload = function() {};

        };

        uploadHttpRequest.upload.onerror = function(event) {

        	console.alert("erreur", event)
            
        };

        var form = new FormData();
        form.append('videoInput', uploadInput.files[0]);
        uploadHttpRequest.send(form);

        timeUpload.started = new Date().getTime();

    }

    else {

        document.getElementById("message-upload").innerHTML = "<h3><?php echo $lang['error_video_type_incorrect']; ?></h3><p>Les formats compatibles sont: mp4, avi, webm, wmv, ogg, mov et ogv.</p>"

    }

}, false);

</script>