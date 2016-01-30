<?php
ini_set('max_execution_time', 300);
require_once ('lib/simple_html_dom.php');

// variables
$GLOBALS['paginacion'] = 0;
$url = 'http://www.fotolog.com/'. $_POST['name'] .'/mosaic/';
$url2 = 'http://www.fotolog.com/'. $_POST['name'] .'/mosaic/';
$html = file_get_html($url);
// Obtener la primera imagen del fotolog, en el album
$PrimeraImagen = $html->find('.wall_block > img');
$inicioDeAlbum = $PrimeraImagen[0]->src;
$hashDIR = substr( md5(microtime()), 1, 22);

if(strlen($inicioDeAlbum) == false){
	echo "La id es incorrecta o este fotolog no existe";
	exit();
}

$GLOBALS['scrapOne'] = true;

// Llamar funcion scrap
mkdir("./fotologs/" . $_POST['name'] . "_" . $hashDIR, 0700, true);
scrap($url, $inicioDeAlbum, $url2,$hashDIR);

function scrap($url, $inicioDeAlbum, $url2, $hashDIR)
{
	$html = file_get_html($url);
	// Obtener imagenes de los albunes
	foreach($html->find('.wall_block > img') as $element)
	{
		$imagenesLinks = $element->src;

		// Si la imagen se repite, y no es la primera del album la funcion se termina
		if (strcasecmp($imagenesLinks, $inicioDeAlbum) == false && !$GLOBALS['scrapOne'])
		{

			// crear un zip con las imagenes
			exec('zip -r '. $hashDIR .' ./fotologs/' . $_POST['name'] . "_" . $hashDIR);
			echo "hash" . $hashDIR;

			// Se termina la execucion de la funcion
			exit();
		}

		// Cambiar la terminacion para obtener la imagen mas grande
		$imaganesReady = str_replace("_t", "_f", $imagenesLinks);
		echo $imaganesReady . "\n";
		$hashrandom = substr( md5(microtime()), 1, 22);
		$hashrandom2 = substr( md5(microtime()), 1, 22);
		file_put_contents("./fotologs/". $_POST['name']. "_" . $hashDIR ."/". $hashrandom . "_" . $hashrandom2 .".png", file_get_contents($imaganesReady));

		// Cuando cambia de la primera esto se desactiva para permitir el cambio de pagina
		$GLOBALS['scrapOne'] = false;
	}

	// Sumar 30 a la url actual para cambiar de album (fotolog ordena los albunes de 30 en 30)
	$numero = $GLOBALS['paginacion'] = $GLOBALS['paginacion'] + 30;
	$url = $url2 . $numero;

	// Empezar el proceso nuevamente con la url actualizada en la paginacion
	scrap($url, $inicioDeAlbum, $url2, $hashDIR);
}
?>