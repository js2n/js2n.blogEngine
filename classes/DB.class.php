<?php

/**
 * DB
 * 
 * 
 * @package    Classes
 * @author     js2n <js2n@domain.com>
 */

class DB extends Mysqli {

const host = 'try2seo.mysql.ukraine.com.ua';
const username = 'try2seo_main';
const passwd = '37yhe8b4';
const db = 'try2seo_main';

public function __construct($host, $user, $pass, $db)  {
	@parent::__construct($host, $user, $pass, $db);
	
	try  {
		if ($this->connect_error)  {
			throw new Exception("Error: $this->connect_error");
		}
	}
	catch (Exception $e)  {
    Helper::errorHandler($e->getMessage());
  }
}

public function __destruct()  {
  $this->close();
}

/**
* 
* Tryes to login user.
*
* @param string $login login
* @param string $passod user password
*/
function login($login, $passwd)  {
	$passwd = crypt($passwd, 'lsd');
	$sql = 'select login, passwd from users where login = ? and passwd = ?';

	if (!$stmt = $this->prepare($sql))  {
		throw new Exception("Not prepare");
	}
	if (!$stmt->bind_param('ss', $login, $passwd))  {
		throw new Exception("Not bind");
	}    
	if (!$stmt->execute())  {
		throw new Exception("Not exec!");
	}
	$stmt->store_result();    

	if ($stmt->num_rows === 1)  {
	  $_SESSION['admin_user'] = $login;
	  header('Location: panel.php');  
	}  
	else  {
	  throw new Exception("No such user!");
	  }
  }
  
/**
* 
* Adds user to the database.
*
* @param string $userName user's name
* @param string $passwd user password
* @return boolean
*/
function addUser($userName, $passwd)  {
  $passwd = crypt($passwd, 'lsd');
  $sql = "select login from users where login = '$userName'";
  if(!$res = $this->query($sql))
    throw new Exception ('Database connection problem, try again later...');
  if ($res->num_rows > 0)  {
    throw new Exception("User $userName already exist");
    return false;
  }  else  {
      $sql = "insert into users (login, passwd) values (?,?)";
        if (!$stmt = $this->prepare($sql))  {
        throw new Exception("Not prepare");
      }
      if (!$stmt->bind_param('ss', $userName, $passwd))  {
        throw new Exception("Not bind");
      }    
      if (!$stmt->execute())  {
        throw new Exception("Not exec!");
      }
      return true;
    }
  }
  
/**
* 
* Get list of users from the database.
*
* @return array
*/
function getUsers()  {
  $sql = 'select login from users';
  $res = $this->query($sql);
  $usersArray = array();
      while ($row = $res->fetch_array(MYSQLI_ASSOC))  {
          $usersArray[] = $row;
      }
  return $usersArray;
}

/**
* 
* Deletes users from the database.
*
* @param $userName user's for delete name
* @return boolean
*/
function delUser($userName)  {
  $sql = "delete from users where login = ?";
  $stmt = $this->prepare($sql);
  $stmt->bind_param('s', $userName);
  if (!$stmt->execute())  {
    throw new Exception('Unable to delete user =(');
    return false;
    }     
  return true;
  } 

/**
* 
* Changes admin's password.
*
* @param $userName user's name
* @param $oldPass old password
* @param $newPass new password
* @return boolean
*/
function changePasswd($user, $oldPass, $newPass)  {
  $oldPass = crypt($oldPass, 'lsd');
  $newPass = crypt($newPass, 'lsd');
  
  $sql = "select login, passwd from users where login = '$user' and passwd = '$oldPass'";
  
  if (!$res = $this->query($sql))
    throw new Exception("Database connection problem...");
  $usersCnt = $res->num_rows;
  if ($usersCnt == 1)  {
    $sql = "update users set passwd = '$newPass' where login = '$user'";
    if(!$this->query($sql))
      throw new Exception("Database connection problem...");
    return true;
  } else {
     throw new Exception("No such user!");
    }
  }

/**
* 
* Adds article to the database.
*
* @param string $title article title
* @param string $meta_title SEO title
* @param string $meta_desc SEO description
* @param string $summary article summary
* @param string $content article content
* @return boolean
*/
function addArticle($article_title, $meta_title, $meta_desc, $summary, $content)  {
  $sql = "insert into articles (title, meta_title, meta_description, summary, content) values (?,?,?,?,?)";
  if (!$stmt = $this->prepare($sql))  {
    throw new Exception("Not prepare");
  }
  if (!$stmt->bind_param('sssss', $article_title, $meta_title, $meta_desc, $summary, $content))  {
    throw new Exception("Not bind");
  }    
  if (!$stmt->execute())  {
    throw new Exception("Not exec!");
  }
  return true;
  }

/**
* 
* Get article from the database.
*
* @param string $article_id article id
* @return array
*/
function getArticle($article_id)  {
  $sql = "select title, meta_title, meta_description, summary, content from articles where articleid = '$article_id'";
  $res = $this->query($sql);
  if ($res->num_rows > 0) {
    $article_info = array();
      while ($row = $res->fetch_array(MYSQLI_ASSOC))  {
        $article_info[] = $row;
      }
    return $article_info;
    } else {
      return false;
    }
  }

/**
* 
* Get list of articles from the database.
*
* @return array
*/
function getArticlesList()  {
  $sql = "select articleid, title from articles";
  $res = $this->query($sql);
  $articles_list = array();
    while ($row = $res->fetch_array(MYSQLI_ASSOC))  {
      $articles_list[] = $row;
    }
  return $articles_list;
  }

/**
* 
* Updates article in the database.
*
* @param string $title article title
* @param string $meta_title SEO title
* @param string $meta_desc SEO description
* @param string $summary article summary
* @param string $content article content
* @return boolean
*/
function updateArticle($article_id, $article_title, $meta_title, $meta_desc, $summary, $content)  {
  $sql = "update articles set title = ?, meta_title = ?, meta_description = ?, summary = ?, content = ? where articleid = $article_id";
  if (!$stmt = $this->prepare($sql))  {
    throw new Exception("Not prepare");
  }
  if (!$stmt->bind_param('sssss', $article_title, $meta_title, $meta_desc, $summary, $content))  {
    throw new Exception("Not bind");
  }    
  if (!$stmt->execute())  {
    throw new Exception("Not exec!");
  }
  return true;
  }
}