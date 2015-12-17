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

$title = 'Manage users';
$description = 'Add, delete and edit users';

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
  $userName = $helper->clnStr($_POST['username'], $db);
  $passwd = $helper->clnStr($_POST['passwd'], $db);
  $passwdAgain = $helper->clnStr($_POST['passwd_again'], $db);
  
  try  {
    if (!$helper->checkForm($_POST))
      throw new Exception('Fill all form fields!');
    if ($passwd !== $passwdAgain)
    	throw new Exception('The passwords must match!');
    if (strlen($passwd) < 6 || strlen($passwd) > 16) 
    	throw new Exception('Password must contain from 0 to 16 characters!');
    if (!$db->addUser($userName, $passwd))  
      throw new Exception('Unable to add user. Try again later...');
  }
  catch (Exception $e)  {
    $helper->errorHandler($e->getMessage());
  }
}

if (isset($_GET['del']))  {
  $userToDel = trim(strip_tags($_GET['del']));
  try {
    $db->delUser($userToDel);
    header('Location: users_manager.php');
  }
  catch (Exception $e)  {
    $db->errorHandler($e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <?php $html->doHTMLHead($title, $description); ?>
</head>
<body>
  <div id="wrapper">
  	<?php $html->doAdminPanelHeader('Users manager'); ?>
  	<?php $html->listUsers($db->getUsers()); ?>
    <form actiom = "" method = "post">
      <fieldset>
        <legend>Add new user</legend>
          <label for = "username" class = "label">Add user:</label>
        	<input type = "text" name = "username" size = "25"><br>
        	<label for = "password" class = "label">Password:</label>
        	<input type = "password" name = "passwd" size = "25"><br>
        	<label for = "passwd_again" class = "label">Password again:</label>
        	<input type = "password" name = "passwd_again" size = "25"><br>
        	<input type = "submit" value = "Add" id = "add-item">
      </fieldset>
    </form>
  </div>
</body>
</html>