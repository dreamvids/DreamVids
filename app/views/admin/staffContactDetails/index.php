<div class="row">
	<h1>Coordonnées du staff</h1>

	<div class="col-lg-12">
		<table class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
					<th>Nom d'utilisateur</th>
					<th>Numéro(s) de tel</th>
					<th>Adresse mail de contact</th>
					<th>Adresse mail PushBullet</th>
					<th>Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($infos as $k => $info): 
					if(!is_object($info->details)){ ?>
						<tr>
							<td><?php echo $info->username; ?></td>
							<td>[à remplir]</td>
							<td>[à remplir]</td>
							<td>[à remplir]</td>
							<td>
								<?php if($info->id == Session::get()->id) { ?>
								<a class="btn-warning btn" href="<?php echo WEBROOT . 'admin/staffContactDetails/edit/'; ?>">Editer</a>
								<?php }else{ echo '--'; }?>
							</td>
						</tr>
					<?php continue; }
						Utils::secureActiveRecordModel($info->details);
					?>

					<tr>
						<td><?php echo $info->username; ?></td>
						<td><?php echo $info->details->tel_1 . "<br>" . $info->details->tel_2;  ?></td>
						<td><?php echo $info->details->email ?></td>
						<td><?php echo $info->details->push_bullet_email ?></td>
						<td>
							<?php if($info->id == Session::get()->id) { ?>
							<a class="btn-warning btn" href="<?php echo WEBROOT . 'admin/staffContactDetails/edit/'; ?>">Editer</a>
							<?php }else{ echo '--'; }?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		
	</div>
</div>


