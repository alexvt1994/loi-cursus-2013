<?php

// We willen graag alle fouten / notices zien
ini_set('display_errors', 1);
error_reporting(E_ALL);

// We laten het script weten dat we met sessies gaan werken
session_start();

// We laten het script weten dat we een plaatje gaan maken
header('Content-type: image/png');

// We defineren een aantal variabelen
$aantal_karakters = 4;
$lijnen = 6;
$fonts =
    array(
        'fonts/times.ttf',
        'fonts/tahoma.ttf',
        'fonts/verdana.ttf'
    );

// We gaan een captcha maken met enkel getallen
$karakters = range(1, 9);

// We maken een lege variabele aan waar we de code in gaan zetten straks
$captcha_code = NULL;

// We maken een for loop om een random 4 cijferige code te maken
for($random_code = 0; $random_code < $aantal_karakters; $random_code++)
{
    // we pakken random getallen uit de array $karakters, we halen er 1 vanaf aangezien een array begint bij 0;
    $random = mt_rand(0, count($karakters) -1);
    
    // we stoppen de gegenereerde code in de variabele $captcha_code
    $captcha_code .= $karakters[$random];
}

$_SESSION["captcha_code"] = sha1($captcha_code);

// we geven de breedte van de afbeelding op
$breedte = $aantal_karakters * 20;
// we geven de lengte van de lijnen op
$lijn_lengte = $breedte;

// we maken het plaatje aan
$image = imagecreatetruecolor($breedte, 45);

// we maken een for loop for de random lijnen
for($i = 0; $i < $lijnen; $i++)
{
    // alle lijnen maken we wit
    $kleur = imagecolorallocate($image, 255, 255, 255);

    imageline($image, mt_rand(2, $lijn_lengte), 1, mt_rand(2, $lijn_lengte), 44, $kleur);
}

// we maken een for loop voor de letters
for($i = 0; $i < $aantal_karakters; $i++)
{
    // we geven alle we maken alle letters wit
    $kleur = imagecolorallocate($image, 255, 255, 255);

    // we zetten de letters op de juiste plaats
    $plaats = $i * 16 + 6;
    
    imagettftext($image, 
                19, 
                mt_rand(-20,20), //willekeurige rotatie
                $plaats, //plaats horizontaal
                mt_rand(20,40), //random plaats verticaal
                $kleur, //willekeurige kleur
                $fonts[array_rand($fonts)], //willekeurig lettertype
                $captcha_code[$i]); //met de letter
}

imagepng($image);
imagedestroy($image);
?>