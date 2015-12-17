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

$title = 'Article manager';
$description = 'Create, change, delete existing articles.';

$menuItems = array(
	                  'add_article.php'    => 'Add article'
	                );
?>

<!DOCTYPE html>
<html>
<head>
  <?php $html->doHTMLHead($title, $description); ?>
</head>
<body>
  <div id="wrapper">
  <?php 
    $html->doAdminPanelHeader('Articles manager');
    $html->doAdminMenu($menuItems); 
    $html->showArticlesInPanel($db->getArticlesList());
  ?>
  </div>
</body>
</html>