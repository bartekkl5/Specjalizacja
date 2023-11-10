<?php 

    require_once dirname(__FILE__).'/../config.php';

    include _ROOT_PATH.'/app/security/check.php';

    function odebranieParam(&$kwota,&$lata,&$procent){
        $kwota = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
        $lata = isset($_REQUEST['lata']) ? $_REQUEST['lata'] : null;
        $procent = isset($_REQUEST['procent']) ? $_REQUEST['procent'] : null;
    }

    function validate(&$kwota,&$lata,&$procent,&$messages) {


        if (!(isset($kwota) && isset($lata) && isset($procent))) {
			return false;
        }

        if ($kwota == "") {
            $messages[] = 'Nie podano kwoty.';
        }

        if ($procent == "") {
            $messages[] = 'Nie podano oprocentowania.';
        }

        if ($lata == "") {
            $messages[] = 'Nie podano czasu spłaty.';
        }

        if (count ( $messages ) != 0) return false;

		if ($procent == "0") {
            $messages[] = 'Oprocentowanie nie może wynosić 0%.';
        }

        if (!is_numeric($procent)) {
            $messages[] = 'Oprocentowanie musi być wartością.';
        }
        if (!is_numeric($kwota)) {
            $messages[] = 'Kwota musi być wartością.';
        }
        if (!is_numeric($lata)) {
            $messages[] = 'Czas spłaty musi być wartością.';
        }

        if (count ( $messages ) != 0) return false;
        else return true;
    }
    
    function process(&$kwota,&$lata,&$procent,&$messages,&$resultRata){
        global $role;

        if ($kwota > 150000 && $role == "user" ) {
            $messages[] = "Maksymalna kwota kredytu dla roli 'user' wynosi 150 000 zł.";
        } 
        if ($procent < 6 && $role == "user" ) {
            $messages[] = "Minimalne oprocentowanie dla roli 'user' wynosi 6%.";
        } 
        if ( count ($messages) == 0 ) {
            $kwota = intval($kwota);
            $stopa = $procent / 100 / 12;
            $stopaPotega = pow(( $stopa + 1) , $czas);
            $resultRata = $kwota * ($stopa) * $stopaPotega / (( $stopaPotega ) -1 );
            $resultRata = round($resultRata, 2);
        }
    }

	$kwota = null;
	$procent = null;
	$lata = null;
	$resultRata = null;
	$messages = array();

     getParams($kwota,$lata,$procent);
	if ( validate($kwota,$lata,$procent,$messages) ) {
		process($kwota,$lata,$procent,$messages,$resultRata);
	}
    include 'calc_view.php';

?>
