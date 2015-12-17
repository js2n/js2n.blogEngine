<?php

/**
 * Html
 * 
 * 
 * @package    Classes
 * @author     js2n <js2n@domain.com>
 */
 class Html {
	
	protected $charset = 'utf-8';
  public $styles = array('/css/styles.css');
  private $scripts = array(
                          '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js',
                          '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js',
                          '/js/scripts.js'
                          );

  function __set($name, $value)  {
  	$this->name = $value; 
  }

	/**
	* 
	* Make html head of page.
	*
	* @param string $title title for page
	* @param string $description description for page
	*/

	public function doHTMLHead($title, $description)  {
		echo "<head>\n";
	  echo "  <title>$title</title>\n";
	  echo "  <meta charset = '$this->charset'>\n";
	  echo "  <meta name = 'description' content = '$description'>\n";
		if (is_array($this->styles))  {
			foreach ($this->styles as $style)  {
				echo  "  <link rel = 'stylesheet' href = '$style'>\n";
			}
		}
		if (is_array($this->scripts))  {
			foreach ($this->scripts as $script)  {
				echo  "  <script src = '$script' type = 'text/javascript'></script>\n";
			}
		}
		echo "</head>\n";
	}
	
	/**
	* 
	* Displays menu in admin panel.
	*
	* @param array $menuItems array of menu items
	*/
	public function doAdminMenu($menuItems)  {
    if ((!is_array($menuItems)) || (count($menuItems) == 0))
      die ('No menu items available...');
    $itemId = 0;
    foreach ($menuItems as $link => $title)  {
      echo '<div class = "adm-button">';
      echo "<div id = 'item_$itemId' class = 'bgr'></div>"; 
      echo "<a href = '$link'>$title</a>";
      echo '</div>';
      $itemId++;
    }
  }

	/**
	* 
	* Displays header in admin panel.
	*
	* @param string $title title for header.
	*/
  public function doAdminPanelHeader($title)  {
    trim(strip_tags($title));
    echo '<div id = "header">';
    echo "<h1>$title</h1>";
    if ($_SERVER['REQUEST_URI'] == '/admin/panel.php') {
      echo '<div class="logout"><a href="logout.php">Log out</a> | <a href="/index.php" target="_blank">View site</a></div>';
    } else {  
      echo '<div class="logout"><a href="panel.php" id="return">Return</a> | <a href="logout.php">Log out</a> | '.
           '<a href="/index.php" target="_blank">View site</a></div>';
         }
    echo '</div>';
  }
	
	/**
	* 
	* List users array in admin panel.
	*
	* @param array $usersArray array of users.
	*/  
  public function listUsers($usersArray)  {
    if (!is_array($usersArray) || count($usersArray) == 0)  {
      echo "<strong>No users in database... yet.</strong>";
    } else  {
      echo "<table class='users'>\n";
      foreach  ($usersArray as $item)  {
        $userName = $item['login'];
        echo "<tr><td>$userName</td><td><a href = 'users_manager.php?del=$userName' id = 'del-user'>Delete</a> | ".
                              "<a href = 'ch_pass.php?user=$userName'>Change password</a></td>\n";
      }
      echo "</table>\n";
      echo '<div class = "clear"></div>';
    }
  }
	
	/**
	* 
	* List articles.
	*
	* @param array $articles_list array of titles & ids.
	*/   
  public function showArticles($articles_list) {
  	echo '<ul>';
  	foreach($articles_list as $article) {
  		echo "<li><a href='/index.php?article_id={$article['articleid']}'>{$article['title']}</a></li>";
  	}
  	echo '</ul>'; 
  }
	
	/**
	* 
	* List articles in admin panel.
	*
	* @param array $articles_list array of titles & ids.
	*/   
  public function showArticlesInPanel($articles_list) {
  	echo '<table class="articles-list">';
  	echo '<tr><th>Article ID</th><th>Article title</th></tr>';
  	foreach($articles_list as $article) {
  		echo "<tr><td>{$article['articleid']}</td><td>{$article['title']}</td>";
  		echo "<td><a href='/admin/edit.php?article_id={$article['articleid']}'>Edit | </a><a href='/admin/article_manager.php?del={$article['articleid']}'>Delete</a></td></tr>";
  	}
  	echo '</table>'; 
  }   
}