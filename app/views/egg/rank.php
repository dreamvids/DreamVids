<div class="middle">
	<h1 class="title">Chasse aux oeufs - Classement des 10 premiers :</h1>
	
		<table class="table">
			<?php
			foreach ($bests as $user){
				echo '<tr>';
				echo '<td>' . $user->username . ' : </td>';
				echo '<td>' . ($user->score) . ' point'. ($user->score > 1 ? 's' : '') .'</td>';
				echo '</tr>';
			}
			?>
		</table>
</div>