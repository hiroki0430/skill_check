<?php

    require('function.php');
    login_check();
    require('dbconnect.php');

    if (!empty($_GET)) {
      $sql = 'DELETE FROM `post` WHERE `post_id`=?';
      $data = array($_GET['my_post_id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      header('Location: mypage.php');
      exit();
    }

