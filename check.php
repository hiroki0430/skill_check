<?php 

    session_start();
    require('dbconnect.php');

    if (!empty($_POST)) {

      $nickname = $_SESSION['infomation']['nickname'];
      $introduce = $_SESSION['infomation']['introduce'];
      $password = $_SESSION['infomation']['password'];

      $sql = 'INSERT INTO `members` SET `nickname` = ?, `introduce` = ?, `password` = ?, `created` = NOW()';
      $data = array($nickname, $introduce, sha1($password));
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      unset($_SESSION);
      header('Location: thanks.php');
      exit;


    }
 ?>





<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./css/Home.css">

<!-- fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

<!-- js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script src="js/script.js"></script>

  <title>My Book</title>
</head>
<body>
   <nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand md-0 h1" style="font-size: 30px;"><i class="fas fa-anchor"></i>   My Book</span>
   </nav>

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <form action="" method="POST" class="form-horizontal">
         <input type="hidden" name="action" value="submit">
          <div class="well">
            登録内容の確認
          </div>
          <table class="table table-striped table-condensed">
            <tbody>
              <tr>
                <td>
                  <div class="text-center">ニックネーム</div>
                </td>
                <td>
                  <div class="text-center"><?php echo $_SESSION['infomation']['nickname']; ?></div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="text-center">自己紹介</div>
                </td>
                <td>
                  <div class="text-center"><?php echo $_SESSION['infomation']['introduce']; ?></div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="text-center">パスワード</div>
                </td>
                <td>
                  <div class="text-center"><?php echo $_SESSION['infomation']['password']; ?></div>
                </td>
              </tr>
            </tbody>
          </table>
          <a href="index.php">&laquo;&nbsp;書き直す</a>
          <input type="submit" class="btn btn-dark" value="会員登録">
      </form>
     </div>
    </div>
    </div>
      
          


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>