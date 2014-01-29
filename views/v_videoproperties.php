<?php

?>

<div class='container'>

	<div class="container" style="width: 80%; float: left;">
		<div class='border-top'></div>
			<h1>Modifier une vidéo<small> <?php echo '"'.$vidTitle.'"'; ?></small></h1>
		<div class='border-bottom'></div>

		<br><br>
	</div>

	<div class='container' style='float: left; width: 50%; '>
		<form role='form' method='post' action=''>
			<div class="form-group">
				<label for="vidTitle"><?php echo $lang['title']; ?></label>
				<input type="test" required="" placeholder="<?php echo $lang['title']; ?>" name="vidTitle" value="<?php echo secure($vidTitle); ?>" class="form-control"/>
			</div>
			<div class="form-group">
				<label for="vidDescription"><?php echo $lang['desc']; ?></label>
				<!--<input type="test" required="" placeholder="<?php echo $lang['desc']; ?>" name="vidDescription" value="<?php echo secure($vidDescription); ?>" class="form-control"/>-->
				<textarea required="" placeholder="<?php echo $lang['desc']; ?>" name="vidDescription" class="form-control"><?php echo secure($vidDescription); ?></textarea>
			</div>
			<div class="form-group">
				<label for="vidTags"><?php echo $lang['tags']; ?></label>
				<input type="test" required="" placeholder="<?php echo $lang['tags']; ?>" name="vidTags" value="<?php echo secure($vidTagsStr); ?>" class="form-control"/>
			</div>

			<label for='visibility'>Visibilité de la video: </label>
			
			<div class="btn-group" data-toggle="buttons">
				<label class="btn btn-success <?php echo ($vidVisibility == 2) ? 'active' : ''; ?>">
					<input type="radio" name="vidVisibility" id="public" value="2" <?php echo ($vidVisibility == 2) ? 'checked="checked"' : ''; ?>> <?php echo $lang['public'] ?>
				</label>
				<label class="btn btn-primary <?php echo ($vidVisibility == 1) ? 'active' : ''; ?>">
					<input type="radio" name="vidVisibility" id="non-listed" value="1" <?php echo ($vidVisibility == 1) ? 'checked="checked"' : ''; ?>> <?php echo $lang['non_listed'] ?>
				</label>
				<label class="btn btn-danger <?php echo ($vidVisibility == 0) ? 'active' : ''; ?>">
					<input type="radio" name="vidVisibility" id="private" value="0" <?php echo ($vidVisibility == 0) ? 'checked="checked"' : ''; ?>> <?php echo $lang['private'] ?>
				</label>
			</div>
			

			<br><br>

			<input type="submit" name="submit" value="<?php echo $lang['update_vid']; ?>" class='btn btn-primary' />
		</form>
	</div>

</div>