<?php
function gen_random_code(){
    //een array maken met kleine letters van a tot z
	$letters = array_merge(range("A","Z"), range("a","z"), range(0, 9));
    //alle letters door elkaar gooien
    shuffle($letters);
    //imploden van alle letters
    $letters = implode($letters);
    //een hash maken van de letters
    $return = sha1($letters);
    
    return $return;
}

function maakpass($lengte, $cijfers = true, $hoofletters = true){
    //als hoofdletters true is, zetten we hoofdletters in de array, anders alleen kleine letters
    $karakters = ($hoofletters == true) ? array_merge(range('A','Z'), range('a', 'z')) : array_merge(range('a', 'z'));

	//als cijfers true is, zetten we cijfers bij de array (2x zodat er wat meer cijfers in komen), anders houden we de array zoals hij was
    $karakters = ($cijfers == true) ? array_merge($karakters, range(0, 9), range(0,9)) : $karakters;
        
    $pass = NULL; //maak een variabele aan voor de pass

	for($i = 0; $i < $lengte; $i++) //maak een loop die net zolang doorgaat tot het aantal karakters van de pass bereikt is
	{
		$pass .= $karakters[array_rand($karakters)]; //voeg een letter uit de array aan de pass toe
    }
        
    return $pass; //geef de pass terug
}
?>