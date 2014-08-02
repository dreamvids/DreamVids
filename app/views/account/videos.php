<div class="content">

	<section class="profile">
		<h1 class="title">Espace membre</h1>

		<?php
			include VIEW.'layouts/account_menu.php';
		?>

		<?php @include $messages; ?>

		<aside class="long-cards-list">

			<?php if(!empty($videos)) { 
				foreach($videos as $video) {
					echo Utils::getVideoCardHTML($video);
				} 
			}?>

			<!--<nav class="pagination">
				<ul>
					<a href="?page=2"><li>Précédent</li></a>
					<li class="current">3</li>
					<a href="?page=4"><li>4</li></a>
					...
					<a href="?page=11"><li>11</li></a>
					<a href="?page=12"><li>12</li></a>
					<a href="?page=4"><li>Suivant</li></a>
				</ul>
			</nav>-->
		</aside>
	</section>

</div>