<?php 
session_start();

// ログインチェックの関数

function login_check()
{

  if(isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time())
  {
    $_SESSION['time'] = time();
  }
  else
  {
    header('Location: login.php');
    exit; 
  }

}


?>