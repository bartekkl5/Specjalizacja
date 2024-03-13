
<?php
require_once dirname(__FILE__).'/config.php';

//przekierowanie przeglądarki klienta (redirect)
include $conf->root_path.'/app/calc.php';
//przekazanie żądania do następnego dokumentu ("forward")
// include _ROOT_PATH.'/app/calc_view.php';