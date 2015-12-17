<?php

session_start();

if (!isset($_SESSION['admin_user'])) { 
  header('Location: index.php');
}

spl_autoload_register(function($class)  {
  include '../classes/' . $class . '.class.php';
});

$html = new Html;
$html->styles = array('/admin/css/styles.css');
$db = new DB(DB::host, DB::username, DB::passwd, DB::db);

$title = 'Admin panel';
$description = 'Administrate articles, users and other.';
$menuItems = array(
	                  'article_manager.php'    => 'Article manager',
	                  'users_manager.php'   => 'Users manager',
	                );
?>

<!DOCTYPE html>
<html>
<head>
  <?php $html->doHTMLHead($title, $description); ?>
</head>
<body>
  <div id = "wrapper">
  <?php 
    $html->doAdminPanelHeader('Admin Panel');
    $html->doAdminMenu($menuItems); 
  ?>
  </div>
</body>
</html>