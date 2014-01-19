<div class="container">
	<div class="container">
		<div class='border-top'></div>
			<h1><?php echo $lang['up_vid']; ?></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class="container" style="width: 40%; float: left;">

		<?php
		echo (isset($err) ) ? '<div class="alert alert-danger">'.$lang['error'].': '.$err.'</div>' : '';
		echo (!isset($err) && isset($_POST['submit']) ) ? '<div id="uploadDoneAlert" class="alert alert-success">'.$uploadDone.'</div>' : '';
		?>

		<form role="from" method="post" enctype="multipart/form-data" action="">
			<label for="videoInput"><?php echo $lang['vid']; ?></label>
			<input type="file" id="videoInput" name="videoInput">
			<p class="help-block"><?php echo $lang['select_vid']; ?></p>
			<div class="progress progress-striped active" id="progress-style">
				<div id="progressbar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					<span class="sr-only"></span>
				</div>
			</div>
			<p id="vid-ok"></p>
		</form>
		
		<form role="form" method="post" action="">
			<div class="form-group">
				<label for="videoTitle"><?php echo $lang['title']; ?></label>
				<input type="text" required class="form-control" name="videoTitle" id="videoTitle" placeholder="<?php echo $lang['title']; ?>">
			</div>

			<div class="form-group">
				<label for="videoDescription"><?php echo $lang['desc']; ?></label>
				<textarea rows="4" cols="50" required class="form-control" name="videoDescription" id="videoDescription" placeholder="<?php echo $lang['desc']; ?>"></textarea>
			</div>

			<div class="form-group">
				<label for="videoTags"><?php echo $lang['tags']; ?></label>
				<input type="text" class="form-control" required name="videoTags" id="videoTags" placeholder="<?php echo $lang['tags']; ?>">
			</div>

			<div class="form-group">
				<label for="videoTumbnail"><?php echo $lang['tumbnail']; ?></label>
				<input type="url" class="form-control" required name="videoTumbnail" id="videoTumbnail" placeholder="http://">
			</div>
			
			<div class="form-group">
				<label for="videoVisibility"><?php echo $lang['visibility']; ?></label>
				<select class="form-control" name="videoVisibility" id="videoVisibility">
					<option value="2"><?php echo $lang['public']; ?></option>
					<option value="1"><?php echo $lang['non_listed']; ?></option>
					<option value="0"><?php echo $lang['private']; ?></option>
				</select>
			</div>

			<br>

			<input type="submit" id="up-submit" disabled="disabled" class="btn btn-primary" name="submit">
		</form>
	</div>
</div>

<script type="text/javascript">
var fileInput = document.getElementById('videoInput'),
progress = document.getElementById('progressbar');

function updateProgress(percent) {
	percent = Math.round(percent*10)/10;
    progress.style.width = percent+'%';
    progress.setAttribute('aria-valuenow', percent);
    document.getElementById('vid-ok').innerHTML = '<b>'+percent+' %</b>';
}

fileInput.onchange = function() {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'index.php?page=upload');
	xhr.upload.onprogress = function(e) {
		updateProgress( (e.loaded/e.total)*100);
	};
	xhr.onload = function() {
		updateProgress(100);
	    document.getElementById('vid-ok').innerHTML += '<br />Upload terminé !';
	    document.getElementById('progress-style').className = 'progress progress-striped';
	    progress.className = 'progress-bar progress-bar-success';
	    document.getElementById('up-submit').removeAttribute('disabled');
	};
	var form = new FormData();
	form.append('videoInput', fileInput.files[0]);
	xhr.send(form);
};
</script>