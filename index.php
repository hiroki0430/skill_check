<?php
    session_start();
    require('dbconnect.php');

    if (!empty($_POST)) {
      if ($_POST['nickname'] == '') {
      $error['nickname'] = 'blank';
      }
      if ($_POST['introduce'] == '') {
      $error['introduce'] = 'blank';
      }
      if ($_POST['password'] == '') {
      $error['password'] = 'blank';

      } elseif (strlen($_POST['password'])< 4) {
      $error['password'] = 'length';
      } elseif (strlen($_POST['password'])> 16) {
      $error['password'] = 'amount';
      }

    if (!isset($error)) {

      // ユーザ名の重複チェックする。
     $sql = 'SELECT COUNT(*) AS `nickname_count` FROM `members` WHERE `nickname` =?';
     $data = array($_POST['nickname']);
     $stmt = $dbh->prepare($sql);
     $stmt->execute($data);
     $nickname_count = $stmt->fetch(PDO::FETCH_ASSOC);

     if ($nickname_count['nickname_count'] >= 1) {
     $error['nickname'] = 'duplicated';
     }
    }

    if (!isset($error['nickname'])) {
     $_SESSION['infomation'] = $_POST;
     header('Location: check.php');
     exit();
     }
    }



?>


<!DOCTYPE html>
<html lang="ja">
<head>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="index.css">

  <!-- fontawesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <script src="js/script.js"></script>

  <meta charset="UTF-8">
  <title>My Book</title>
</head>
<body>
 <nav class="navbar navbar-dark bg-dark">
  <span class="navbar-brand md-0 h1" style="font-size: 30px;"><i class="fas fa-anchor"></i>   My Book</span>
</nav>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <legend>会員登録</legend>
      <form action="" method="POST" class="form-horizontal" role="form">
        <div class="form-group">
          <label class="col-sm-4 control-label">ニックネーム</label>
          <div class="col-sm-8">
            <input type="text" name="nickname" class="form-control">
            <?php if (isset($error['nickname']) && $error['nickname'] == 'blank') { ?>
              <p class="alert alert-dismissible alert-danger">ニックネームを入力してください。</p>
            <?php } elseif (isset($error['nickname']) && $error['nickname'] == 'duplicated') { ?>
              <p class="alert alert-dismissible alert-danger"> 入力されたニックネームは登録済みです。</p>
            <?php } ?>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label">自己紹介</label>
          <div class="col-sm-8">
            <input type="text" name="introduce" class="form-control">
            <?php if (isset($error['introduce']) && $error['introduce'] == 'blank') { ?>
             <p class="alert alert-dismissible alert-danger">自己紹介を入力してください。</p>
           <?php } ?>
         </div>
       </div>
       <div class="form-group">
        <label class="col-sm-4 control-label">パスワード</label>
        <div class="col-sm-8">
          <input type="password" name="password" class="form-control">
          <?php if (isset($error['password']) && $error['password'] == 'blank') { ?>
           <p class="alert alert-dismissible alert-danger">パスワードを入力してください。</p>
         <?php } elseif (isset($error['password']) && $error['password'] == 'length'){ ?>
           <p class="alert alert-dismissible alert-danger">４文字以上入力してください。</p>
         <?php } elseif (isset($error['password']) && $error['password'] == 'amount'){ ?>
           <p class="alert alert-dismissible alert-danger">16文字以内で入力してください。</p>
         <?php } ?>
       </div>
     </div>
     <div class="form-group">
      <input type="submit" class="btn btn-dark" value="確認画面へ">
    </div>
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