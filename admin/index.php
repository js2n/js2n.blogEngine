<?php

session_start();

spl_autoload_register(function($class)  {
  include '../classes/' . $class . '.class.php';
});

$title = 'Login, please';
$description = 'Login form';

$html = new Html;
$html->styles = array('/admin/css/styles.css');

$helper = new Helper;
$db = new DB(DB::host, DB::username, DB::passwd, DB::db);

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
	if (!$helper->checkForm($_POST))  {
		Helper::errorHandler('Fill all form fields!');
	}
	else  {
		$login = $helper->clnStr(($_POST['login']), $db);
		$passwd = $helper->clnStr(($_POST['passwd']), $db);
		try {
	    $db->login($login, $passwd);
		}
		catch (Exception $e) {
			Helper::errorHandler($e->getMessage());
		}
	}
}
?>

<!DOCTYPE html>
<html>
  <?php $html->doHTMLHead($title, $description); ?>
<body>
  <div id = "wrapper">
	  <div id = "header">
	    <h1>Admin panel.</h1>
	  </div>
		<form action = "" method = "post">
		  <fieldset>
			  <legend>Log in, please</legend>
			  <label for = "login" class = "label">Login:</label>
			  <input type = "text" size = "20" name = "login"><br>
			  <label for = "passwd" class = "label">Password:</label>
			  <input type = "password" size = "20" name = "passwd"><br>
			  <input type = "submit" value = "Submit!" id = "add-item">
		  </fieldset>
		</form>
  </div>
</body>
</html>