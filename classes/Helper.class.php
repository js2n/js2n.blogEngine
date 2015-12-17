<?php

/**
 * Helper
 * 
 * 
 * @package    Classes
 * @author     js2n <js2n@domain.com>
 */

class Helper {
  
 /**
 * 
 * Handle and display error messages.
 *
 * @param string $message error message
 */
  
  public static function errorHandler($message)  {
		echo "<div id = 'error'>$message</div>";
	}

  /**
  * 
  * Checks form data.
  *
  * @param string $formData $_POST form data
  * @return boolean
  */
  function checkForm($formData)  {
    foreach ($formData as $key => $value)  {
        if ((!isset($key)) || ($value == '')) return false;
    }
    return true;
  }

  /**
  * 
  * Checks email.
  *
  * @param string $email user's email
  * @return boolean
  */
  public function checkEmail($email)  {
    if (preg_match('/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/', $email))  {
      return true;
    }  else  {
      return false;
    }
  }
  
  /**
  * 
  * Clears form inputs.
  *
  * @param string $str some string
  * @param object $db mysqli object
  * @return clean string
  */
  function clnStr($str, $db)  {
    return $db->escape_string(strip_tags(trim($str)));
  }
}