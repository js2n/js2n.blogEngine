<?php
session_start();

if (!isset($_SESSION['admin_user']))  
  header('Location: index.php');

spl_autoload_register(function($class)  {
  include '../classes/' . $class . '.class.php';
});

$html = new Html;
$html->styles = array('/admin/css/styles.css');
$db = new DB(DB::host, DB::username, DB::passwd, DB::db);
$helper = new Helper;

$title = 'Change password';
$description = 'Change password for any user';

if (!isset($_GET['user']))
	header('Location: user_manager.php');
$user = trim(strip_tags($_GET['user']));

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
	$oldPass = $helper->clnStr($_POST['old_passwd'], $db);
	$newPass = $helper->clnStr($_POST['new_passwd'], $db);
	$passAgain = $helper->clnStr($_POST['passwd_again'], $db);
  try  {
    if (!$helper->checkForm($_POST))
    	throw new Exception("Fill all form fields!");
    if ($newPass !== $passAgain)
    	throw new Exception('The passwords must match!');
    if (strlen($newPass) < 6 || strlen($newPass) > 16) 
    	throw new Exception('Password must contain from 0 to 16 characters!');
    if ($db->changePasswd($user, $oldPass, $newPass))  
      throw new Exception("Password for \"$user\" was changed");
  }
  catch (Exception $e)  {
  	$helper->errorHandler($e->getMessage());
  }

}
?>
<!DOCTYPE html>
<html>
<head>
	<?php $html->doHTMLHead($title, $description); ?>
</head>
<body>
  <div id = "wrapper">
  	<?php $html->doAdminPanelHeader("Change password for $user"); ?>
	  <form actiom = "" method = "post">
	      <fieldset>
	        <legend>Change password</legend>
	          <label for = "old_passwd" class = "label">Old password:</label>
	        	<input type = "password" name = "old_passwd" size = "25"><br>
	        	<label for = "new_passwd" class = "label">New password:</label>
	        	<input type = "password" name = "new_passwd" size = "25"><br>
	        	<label for = "passwd_again" class = "label">Password again:</label>
	        	<input type = "password" name = "passwd_again" size = "25"><br>
	        	<input type = "submit" value = "Add" id = "add-item">
	      </fieldset>
	    </form>
  </div>
</body>
</html>