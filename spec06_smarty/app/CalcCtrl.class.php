<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.

require_once $conf->root_path.'/lib/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/CalcForm.class.php';
require_once $conf->root_path.'/app/CalcResult.class.php';

/** Kontroler kalkulatora
 * @author Przemysław Kudłacik
 *
 */
class CalcCtrl {

	private $msgs;   //wiadomości dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->msgs = new Messages();
		$this->form = new CalcForm();
		$this->result = new CalcResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->amount = isset($_REQUEST ['amount']) ? $_REQUEST ['amount'] : null;
		$this->form->years = isset($_REQUEST ['years']) ? $_REQUEST ['years'] : null;
		$this->form->percent = isset($_REQUEST ['percent']) ? $_REQUEST ['percent'] : null;
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->amount ) && isset ( $this->form->years ) && isset ( $this->form->percent ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false; //zakończ walidację z błędem
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->amount == "") {
			$this->msgs->addError('Nie podano liczby kwoty');
		}
		if ($this->form->years == "") {
			$this->msgs->addError('Nie podano liczby lat');
		}
		if ($this->form->percent == "") {
			$this->msgs->addError('Nie podano liczby procent');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! $this->msgs->isError()) {
			
			// sprawdzenie, czy $amount i $y są liczbami całkowitymi
			if (! is_numeric ( $this->form->amount )) {
				$this->msgs->addError('Kwota nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->years )) {
				$this->msgs->addError('rok nie jest liczbą całkowitą');
			}
			if (! is_numeric ( $this->form->percent )) {
				$this->msgs->addError('Procent nie jest liczbą całkowitą');
			}
		}
		
		return ! $this->msgs->isError();
	}
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getparams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->amount = intval($this->form->amount);
			$this->form->years = intval($this->form->years);
			$this->form->percent = floatval($this->form->percent);
			$this->msgs->addInfo('Parametry poprawne.');
				
			//wykonanie percenteracji
			// switch ($this->form->percent) {
			// 	case 'minus' :
			// 		$this->result->result = $this->form->amount - $this->form->y;
			// 		$this->result->percent_name = '-';
			// 		break;
			// 	case 'times' :
			// 		$this->result->result = $this->form->amount * $this->form->y;
			// 		$this->result->percent_name = '*';
			// 		break;
			// 	case 'div' :
			// 		$this->result->result = $this->form->amount / $this->form->y;
			// 		$this->result->percent_name = '/';
			// 		break;
			// 	default :
			// 		$this->result->result = $this->form->amount + $this->form->y;
			// 		$this->result->percent_name = '+';
			// 		break;
			// }
			
		
				
				
				$percent2 = ($this->form->percent + 100 ) * $this->form->years;
				$all = ($this->form->amount * $percent2) / 100;
				$this->result->result  = $all/12;
				
			
			$this->msgs->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		global $conf;
		
		$smarty = new Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Przykład 05');
		$smarty->assign('page_description','Obiektowość. Funkcjonalność aplikacji zamknięta w metodach różnych obiektów. Pełen model MVC.');
		$smarty->assign('page_header','Obiekty w PHP');
				
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->display($conf->root_path.'/app/calc.html');
	}
}
