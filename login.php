<?php 

    session_start();
    require('dbconnect.php');

    if (isset($_COOKIE['nickname']) && !empty($_COOKIE['nickname'])) {

      $_POST['nickname'] = $_COOKIE['nickname']; 
      $_POST['password'] = $_COOKIE['password'];

      $_POST['save'] = 'on';

    }

    if (!empty($_POST)) {

      $sql = 'SELECT * FROM `members` WHERE `nickname` = ? AND `password` = ?';
      $data = array($_POST['nickname'],sha1($_POST['password']));
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $member = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($member == false) {
        $error['login'] = 'failed';
      }else{
        $_SESSION['id'] = $member['member_id'];
        $_SESSION['time'] = time();

// 自動ログイン
        if ($_POST['save'] == 'on') {
          setcookie('nickname',$_POST['nickname'], time()+60*60*24*14);
          setcookie('password',$_POST['password'] , time()+60*60*24*14);
        }
        header('Location: Home.php');
        exit;
      }
    }
 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="Home.css">

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
      <div class="col-md-12">
        <form method="POST">
          <legend>ログイン</legend>
          <div class="form-group">
            <label for="exampleInputEmail1">ニックネーム</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="nickname">
          </div>

          <div class="form-group">
            <label for="exampleTextarea">パスワード</label>
            <input class="form-control" type="password" name="password">
          </div>
          <?php if(isset($error['login']) && $error['login'] == 'failed') { ?>
            <p class="alert alert-dismissible alert-danger"> ニックネームかパスワードが間違っています。</p>
          <?php } ?>
          <div class="form-group">
            <label class="col-sm-4 control-label">自動ログイン</label>
            <div class="col-sm-8">
              <input type="checkbox" name="save" value="on">オンにする
            </div>
          </div>
          <fieldset class="form-group">
            <button type="submit" class="btn btn-dark">ログイン</button>
          </fieldset>
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