<?php

session_start();

spl_autoload_register(function ($class) {
  include 'classes/' . $class . '.class.php';
});

$db = new DB(DB::host, DB::username, DB::passwd, DB::db);
$html = new Html;
$helper = new Helper;

if (!isset($_GET['article_id'])) {
  $article_id = 7;
} else {
  $article_id =intval($_GET['article_id']);
}


$article_info = $db->getArticle($article_id);

if ($article_info === false) {
  $article_info = array();
  $article_info[0]['title'] = 'Такой статьи не существует!';
  $article_info[0]['meta_title'] = 'Нет статьи!';
}

?>

<!DOCTYPE html>
<html>
<head>
  <title><?php echo $article_info[0]['meta_title']; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?php echo $article_info[0]['meta_description']; ?>">
  <link rel="stylesheet" type="text/css" href="/css/styles.css">
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-38988257-12', 'auto');
    ga('send', 'pageview');
  </script>
</head>
<body>
  <!-- Headline -->
  <div id="headline">
    <div class="container">
	  <span class="logo"><a href="http://try2seo.com">try2seo.com</a></span>
      <span class="slogan">Поисковая оптимизация сайтов.</span>
  	</div>
  </div>

  <!-- Table of contents -->
  <div class="container">
    <div id="table-of-contents">
      <h3>Оглавление</h3>
      	<?php $html->showArticles($db->getArticlesList()); ?>
    </div>

  <!-- Article -->
    <div id="article">

      <h1><?php echo $article_info[0]['title']; ?></h1>
	  	<?php if (!isset($article_info[0]['summary'])) : ?>
        <!-- No Summary -->
      <?php else : ?>
        <div id="table-of-article-contents">
          <h3>В этой статье:</h3>
          <?php echo $article_info[0]['summary']; ?>
        </div>
      <?php endif; ?>
	  <?php if (!isset($article_info[0]['content'])) : ?>
      <!-- No content -->
    <?php else : ?>
      <?php echo $article_info[0]['content']; ?>
    <?php endif; ?>
    </div>
  </div>

  <!-- Social buttons -->
  <div id="social-bottons">
  </div>

  <!-- Footer -->
  <div id="footer">
  	<div class="container">
  		<p>try2seo.com | 2014</p>
  	</div>
  </div>
</body>
</html>