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
$helper = new Helper;

$title = 'Add article';
$description = 'Add a new article.';

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
  $article_title = $helper->clnStr($_POST['title'], $db);
  $meta_title = $helper->clnStr($_POST['meta_title'], $db);
  $meta_desc = $helper->clnStr($_POST['meta_description'], $db);
  $summary = strip_tags($_POST['summary'], '<ul><li>');
  $content = strip_tags($_POST['content'],'<ul><li><p><table><tr><td><th><h2><h1><h3><em><strong><a><code>');

  try  {
    if (!$helper->checkForm($_POST))
      throw new Exception('Fill all form fields!');
    if (!$db->addArticle($article_title, $meta_title, $meta_desc, $summary, $content))
      throw new Exception('Unable to add new article. Try again later...');
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
  <?php
    $html->doAdminPanelHeader('Admin Panel');
  ?>
  <form actiom = "" method = "post">
    <fieldset>
      <legend>Add new article:</legend>
        <label for = "title" class = "label">Article title:</label>
      	<input type = "text" name = "title" size = "35"><br>
      	<label for = "meta_title" class = "label">Meta title:</label>
      	<input type = "text" name = "meta_title" size = "35"><br>
      	<label for = "meta_description" class = "label">Meta description:</label>
      	<input type = "text" name = "meta_description" size = "35"><br>
      	<label for = "summary" class = "label">Summary:</label>
      	<textarea name = "summary" cols="45" rows="5"></textarea><br>
      	<label for = "content" class = "label">Content:</label>
      	<textarea name = "content" cols="45" rows="30"></textarea><br>
      	<input type = "submit" value = "Add" id = "add-item">
    </fieldset>
  </form>
  </div>
</body>
</html>