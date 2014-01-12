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

	return($imput);
}  
?>
