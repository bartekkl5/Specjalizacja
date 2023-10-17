<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
</head>
<body>
<section id="caly">
<section id="formularz">
	<form action="<?php print(_APP_URL);?>/app/calc.php" method="post">
		<label for="kwota">Kwota kredytu: </label>
		<input id="kwota" type="text" name="kwota" value="<?php isset($k) ? print($k):''; ?>" /><br />
		<label for="lata">Ilość Lat: </label>
		<input type="number" id="lata" name="lata"><br>
		<label for="procent">Oprocentowanie: </label>
		<input id="procent" type="text" name="procent" value="<?php isset($p) ? print($p):''; ?>" /> % <br />
		<input type="submit" value="Oblicz" />
	</form>	
</section>
	<?php
	
	if (isset($messages)) {
		if (count ( $messages ) > 0) {
			echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: red; width:300px;">';
			foreach ( $messages as $key => $msg ) {
				echo '<li>'.$msg.'</li>';
			}
			echo '</ol>';
		}
	}
	?>

	<?php if (isset($result)){ ?>
	<div  style="margin: 15px; padding: 8px; border-radius: 6px; background-color: purple; width:350px;">
	<?php echo 'Rata miesięczna: '.$result."<br>".'Cała kwota: '.$all; ?>
	</div>
	<?php } ?>
</section>
</body>
</html>