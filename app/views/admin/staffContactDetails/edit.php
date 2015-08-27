<?php
	$user = Session::get();
	$tel_1 = '';
	$tel_2 = '';
	$email = $user->email;
	$push_bullet_email = $user->email;
if($user->getStaffDetails()){
	$tel_1 = $user->getStaffDetails()->tel_1;
	$tel_2 = $user->getStaffDetails()->tel_2;
	$email = $user->getStaffDetails()->email;
	$push_bullet_email = $user->getStaffDetails()->push_bullet_email;
}
?>

<div class="row">
	<h1>Vos coordonées <a href="<?php echo WEBROOT . 'admin/staffContactDetails'; ?>"><small>Retour à la liste</small></a></h1>

	<div class="col-lg-4 col-lg-offset-4">
		<form action="<?php echo WEBROOT . 'admin/staffContactDetails/' . $user->id; ?>" method="post">
			<input type="hidden" name="_method" value="PUT">
			
			<label for="tel_1">N° de tel 1 :</label>
			<input class="form-control" type="tel" name="tel_1" value="<?php echo $tel_1; ?>">
			<br>
			<label for="tel_2">N° de tel 2 :</label>
			<input class="form-control"type="tel" name="tel_2" value="<?php echo $tel_2; ?>">
			<br>
			<label for="email">Adresse mail de contact :</label>
			<input class="form-control"type="email" name="email" value="<?php echo $email; ?>">
			<br>
			<label for="push_bullet_email">Adresse mail PushBullet :</label>
			<input class="form-control"type="email" name="push_bullet_email" value="<?php echo $push_bullet_email; ?>">
			<br>
			<button type="submit" name="type" value="contact" class="btn btn-primary">Valider</button>
			
		</form>		
	</div>
</div>


