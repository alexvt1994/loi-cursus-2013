<?php
session_start();
function initialize(){
	$_SESSION['bingo']['rij'][1] = vul_bingokaart(10, 19, 6);
	$_SESSION['bingo']['rij'][2] = vul_bingokaart(20, 29, 6);
	$_SESSION['bingo']['rij'][3] = vul_bingokaart(30, 39, 6);
	$_SESSION['bingo']['rij'][4] = vul_bingokaart(40, 49, 6);
	$_SESSION['bingo']['rij'][5] = vul_bingokaart(50, 59, 6);
	$_SESSION['bingo']['rij'][6] = vul_bingokaart(60, 70, 6);
	$_SESSION['bingo']['getrokkengetallen'] = array();
}
function vul_bingokaart($min, $max, $limit){
    $array = array();
    $numbers = range($min,$max);
	shuffle($numbers);
    for($i = 1;$i <= $limit;$i++){ $array[$i] = $numbers[$i]; }
    return $array;
}
function display_bingokaart(){
	$limit = 6;
	$output = '<table>'.PHP_EOL;
    for($i = 1;$i <= $limit;$i++){
		$output .= '<tr>';
		foreach($_SESSION['bingo']['rij'][$i] as $cijfer){
			$output .= (in_array($cijfer,$_SESSION['bingo']['getrokkengetallen']))?'<td class="green">'.$cijfer.'</td>':'<td>'.$cijfer.'</td>';
		}
		$output .= '</tr>'.PHP_EOL;
	}
	$output .= '</table>';
	return $output;
}
function trek_getal(){
	$random = rand(10, 70);
	if(in_array($random, $_SESSION['bingo']['getrokkengetallen'])){
		// getal is al getrokken en er word opnieuw getrokken
		trek_getal();
	}else{
		// getal is uniek en zal word toegevoegt aan de array
		array_push($_SESSION['bingo']['getrokkengetallen'], $random);
	}
}
function display_getrokkengetallen($error=NULL){
	$cijfers = NULL;
	if(!empty($_SESSION['bingo']['getrokkengetallen'])){
		foreach($_SESSION['bingo']['getrokkengetallen'] as $cijfer){
			$cijfers .= $cijfer.' ';
		}
		return $cijfers;
	}else{
		return $error;
	}
}
function count_getrokkengetallen(){
	$count = 0;
	foreach($_SESSION['bingo']['getrokkengetallen'] as $cijfer){
		$count++;
	}
	return $count;
}
function controlleer_bingo(){
	$limit = 6;
        $teller = array();
        $limit;
	/* Check verticale rijen */
	for($x = 1;$x <= $limit;$x++){
		$teller['y'][$x]=0;
		for($y = 1;$y <= $limit;$y++){
			if(in_array($_SESSION['bingo']['rij'][$y][$x],$_SESSION['bingo']['getrokkengetallen'])){
				$teller['y'][$x]++;
			}
		}
	}
	/* Check horizontale rijen */
	for($y = 1;$y <= $limit;$y++){
		$teller['x'][$y]=0;
		for($x = 1;$x <= $limit;$x++){
			if(in_array($_SESSION['bingo']['rij'][$y][$x],$_SESSION['bingo']['getrokkengetallen'])){
				$teller['x'][$y]++;
			}
		}
	}
	/* Checken of $teller ['x'] of ['y'] ergens 6 punten bevat */
	$teller['z']=0;
	for($z = 1;$z <= $limit;$z++){
		if($teller['x'][$z]==$limit OR $teller['y'][$z]==$limit){
			$teller['z']++;
		}
	}
	if($teller['z']!=0){
		return true;
	}else{
		return false;
	}
}

if(!isset($_SESSION['bingo'])){ initialize(); }
if(isset($_GET['action'])){
	if($_GET['action']=='trek_getal' && !controlleer_bingo()){
		trek_getal();
	}elseif($_GET['action']=='reset'){
		unset($_SESSION['bingo']);
		initialize();
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Inzendopdracht 051R3</title>
		<style>
			table,tr,td{border:1px solid;}
			td{padding:5px;}
			td.green{background-color:green;}
		</style>
	</head>
	<body>
<?php
	echo display_bingokaart().'<br />'.PHP_EOL;
	echo (controlleer_bingo())?'<strong>Gewonnen!</strong> | ':'<a href="?action=trek_getal">Trek getal!</a> | ';
	echo '<a href="?action=reset">Reset</a><br />';
	echo '<br />'.PHP_EOL;
	echo 'Aantal getallen dat is getrokken: <strong>'.count_getrokkengetallen().'</strong>'.PHP_EOL;
	echo '<br />'.PHP_EOL;
	echo '<br />'.PHP_EOL;
	echo 'Getrokken getallen:<br />'.PHP_EOL;
	echo '<strong>'.display_getrokkengetallen('Nog geen getallen getrokken').'</strong><br />'.PHP_EOL;
?>
	</body>
</html>