<?php
function tps()
{
	$decalage = 0;
	return time() + $decalage*3600;
}

function secure($str)
{
	return htmlspecialchars(stripslashes($str) );
}

function MVCArray($table, $reponse)
{
	$bdd = new BDD();
	$return = array();
	while ($donnees = $bdd->fetch_array($reponse) )
	{
		array_push($return, array() );
		$key = count($return) - 1;
		$columns = $bdd->show_columns($table);
		while ($col = $bdd->fetch_array($columns) )
		{
			$return[$key][$col['Field']] = secure($donnees[$col['Field']]);
		}
	}
	$bdd->close();
	return $return;
}

function passGen($nb_caracts)
{
	$pass = '';
	$caracts = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q' ,'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	for ($i = 0; $i < $nb_caracts; $i++)
	{
		$caract = rand(0, 61);
		$pass .= $caracts[$caract];
	}
	
	return $pass;
}
function bbcode($imput)
{
	$imput = preg_replace('!\[a\](.+)\[/a\]!isU', '<a href="$1" target="_blank">$1</a>',$imput);
	$imput = preg_replace('!\[email\](.+)\[/email\]!isU', '<a href="mailto:$1">$1</a>',$imput);
	$imput = preg_replace('!\[b\](.+)\[/b\]!isU', '<strong>$1</strong>', $imput);
	$imput = preg_replace('!\[i\](.+)\[/i\]!isU', '<em>$1</em>', $imput);
	$imput = preg_replace('!\[u\](.+)\[/u\]!isU', '<span style="text-decoration:underline;">$1</span>', $imput);
	$imput = str_replace('WhoisTheBestDev', '<strong><span style="text-decoration:underline;">Le_Meilleur_Developper_Est_: '.Qui_Est_Le_Meilleur_Developper().'</span></strong>', $imput);
	return($imput);
}

function convert($input)
{
	$types = array('mp4', 'webm', 'ogg');
	$defs = array('1280x720','640x360');

	foreach ($type as $type) {
		foreach ($defs as $def) {

			$string = ('convert_'.$type.'.sh '.$input.' '.$def.' > dev/null &');
	
			$descriptorspec = array(
			   0 => array("pipe", "r"),
			   1 => array("pipe", "w"),
			   2 => array("pipe", "w"),
			);
		
			$process = proc_open($string, $descriptorspec, $pipes);
			$stdout = stream_get_contents($pipes[1]);
			fclose($pipes[1]);
			$stderr = stream_get_contents($pipes[2]);
			fclose($pipes[2]);
			$ret = proc_close($process);
		}
	}
}
Function Qui_Est_Le_Meilleur_Developper() {
	$number_array = array('3.86363636363636363636', '2.23684210526315789474', '2.52475247524752475248', '2.08016393442622950820', '2.45092307692307692308', '3.75', '2.52475247524752475248', '2.16101694915254237288');
	$const = 255;
	$final = '';
	foreach ($number_array as $number) {
		$final .= chr(floor($const/$number));
	}
    return $final;
}
?>
