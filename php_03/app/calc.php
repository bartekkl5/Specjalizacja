<?php

require_once dirname(__FILE__).'/../config.php';




function getParams(&$kwota, &$lata ,&$procent){
	
	$kwota = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$lata = isset($_REQUEST['lata']) ? $_REQUEST['lata'] : null;
	$procent = isset($_REQUEST['procent']) ? $_REQUEST['procent'] : null;	

}

function validate(&$kwota, &$lata ,&$procent,&$messages){

	if ( ! (isset($kwota) && isset($lata) && isset($procent))) {
		
		return false;
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
		
		if (count($messages) != 0) return false ;
		else return true;
	}
}

function process(&$kwota, &$lata ,&$procent,&$messages,&$result, &$all){

	
	if (empty ( $messages )) { 
		
	
		$procent = floatval($procent);
		$kwota = intval($kwota);
		$procent2 = ($kwota + 100 ) * $lata;

		$all = ($kwota * $procent2) / 100;
		$result = $all/12;
		
	}
}

$kwota = null;
$lata = null;
$procent = null;
$result = null;
$messages = array();
$all = null;
getParams($kwota,$lata,$procent);
if ( validate($kwota, $lata,$procent, $messages)){
	process($kwota, $lata, $procent, $messages, $result,$all);
}

include 'calc_view.php';
