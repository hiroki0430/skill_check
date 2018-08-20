<?php 

    require('function.php');
    login_check();
    require('dbconnect.php');

    if (!empty($_GET)) {
      if (isset($_GET['like_book_id'])) {

        $sql = 'INSERT INTO `likes` SET `member_id` =?, `post_id` =?';
        $data = array($_SESSION['id'], $_GET['like_book_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: Home.php');
        exit();

      }

      if (!empty($_GET)) {
          if (isset($_GET['unlike_book_id'])) {
              $unlike_sql = 'DELETE FROM `likes` WHERE `member_id` =? AND `post_id` =?';
              $unlike_data = array($_SESSION['id'], $_GET['unlike_book_id']);
              $unlike_stmt = $dbh->prepare($unlike_sql);
              $unlike_stmt->execute($unlike_data);

              header('Location: Home.php');
              exit();
          }
      }
    }



