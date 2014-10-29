<?php
class Citrouille {
	private $id;
	private $emplacement;
	private $cle;
	
	public function __construct($emplacement, $id=0) {
		$bdd = new BDD();
		if ($emplacement != 0) {
			$cond = "WHERE emplacement='".$bdd->real_escape_string($emplacement)."' LIMIT 1";
		}
		else {
			$cond = "WHERE id='".$bdd->real_escape_string($id)."'";
		}
		
		$cit = $bdd->fetch_array($bdd->count('nb_cit', "citrouilles", $cond));
		if ($cit['nb_cit'] > 0) {
			$rep = $bdd->select("*", "citrouilles", $cond);
			$data = $bdd->fetch_array($rep);
			$bdd->close();
			$this->id = $data['id'];
			$this->emplacement = $data['emplacement'];
			$this->cle = $data['cle'];
		}
		else {
			$this->id = 0;
			$this->emplacement = 0;
			$this->cle = 0;
		}
	}
	
	public function exists() {
		return ($this->id !== 0);
	}
	
	public function display($type = 0) {
		switch ($type) {
			case 1:
				echo '<div class="card video">
			    	<div class="thumbnail" style="background-image:url(img/citrouille.png)">
			    		<a href="bouuh.php?id='.$this->id.'" class="overlay"></a>
			    	</div>
			    	<div class="description">
			    		<a href="bouuh.php?id='.$this->id.'"><h4>BOUUH !</h4></a>
			    		<div>
			    			<span class="view">666</span>
			    			<a class="channel" href="bouuh.php?id='.$this->id.'">La citrouille maléfique</a>
			    		</div>
			    	</div>
			    </div>';
			break;
			
			case 2:
				echo '<div class="col-lg-4">
					<h2>BOUUH !</h2>
					<a href="bouuh.php?id='.$this->id.'"><img src="img/citrouille.png" class="img-circle" width="100"></a>
					<p class="text-default">
						Arrête de lire ce texte et clique sur cette foutue citrouille avant que quelqu\'un d\'autre le fasse à te place ! ;D
					</p>
					<p>
						<a class="btn btn-primary" href="bouuh.php?id='.$this->id.'" target="_blank" role="button">
							Suivez-la
						</a>
					</p>
				</div>';
			break;
			
			default:
				echo '<p><a href="bouuh.php?id='.$this->id.'"><img title="BOUUH !" width="100" src="img/citrouille.png" alt="BOUUH !" /></a></p>';
			break;
		}
	}
	
	public function remove() {
		$bdd = new BDD();
		$bdd->delete("citrouilles", "WHERE id=".$this->id);
		$bdd->close();
	}
	
	public function getKey() {
		return $this->cle;
	}
}