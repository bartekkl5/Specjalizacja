<?php

require_once dirname(__FILE__).'/../config.php';

$kwota = $_REQUEST ['kwota'];
$lata = $_REQUEST ['lata'];
$procent = $_REQUEST ['procent'];


if ( ! (isset($kwota) && isset($lata) && isset($procent))) {

	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

if ( $kwota == "") {
	$messages [] = 'Nie podano kwoty';
}
if ( $lata == "") {
	$messages [] = 'Nie podano liczby lat';
}
if ( $procent == "") {
	$messages [] = 'Nie podano procentów';
}

if (empty( $messages )) {
	

	if (! is_numeric( $kwota )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	if (! is_numeric( $procent )) {
		$messages [] = 'Nie jest to liczba float';
	}
	

}


if (empty ( $messages )) { 
	

	$procent= floatval($procent);
	$kwpta = intval($kwota);
	$procent2 = ($procent + 100 ) * $lata;

	$all = ($kwota * $procent2) / 100;
	$result = $all/12;
	
}


include 'calc_view.php';