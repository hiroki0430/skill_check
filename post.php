<?php 

    require('dbconnect.php');
    session_start();

    if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
      $_SESSION['time'] = time();

      $login_sql = 'SELECT * FROM `members` WHERE `member_id` = ?';
      $login_data = array($_SESSION['id']);
      $login_stmt = $dbh->prepare($login_sql);
      $login_stmt->execute($login_data);
      $login_member = $login_stmt->fetch(PDO::FETCH_ASSOC);
    }else{
      header('Location: login.php');
      exit();
    }

// バリデーション !empty か　!issetを使うこともできるぜ
    if (!empty($_POST)) {

      if ($_POST['title'] == '') {
        $error['title'] == 'blank';
      }
      if ($_POST['comment'] == '') {
        $error['comment'] == 'blank';
      }
      
      // var_dump($error);die();

    if (!isset($error)) {
      $ext = substr($_FILES['picture']['name'],-3);
      $ext = strtolower($ext);

      if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
        $picture = date('YmdHis') . $_FILES['picture']['name'];
        // var_dump($_FILES['picture']['tmp_name']);die();
        move_uploaded_file($_FILES['picture']['tmp_name'], 'picture/'.$picture);


        $title = htmlspecialchars($_POST['title']);
        $comment = htmlspecialchars($_POST['comment']);
        $member_id = $_SESSION['id'];

        $sql = 'INSERT INTO `post` SET `post_name` =?, `post_comment` =?, `post_pic` =?, `member_id` =?, `created` =NOW()';
        $data = array($title, $comment, $picture, $member_id);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: Home.php');
        exit();
        }
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

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="home.php" style="font-size: 30px;"><i class="fas fa-anchor"></i>   My Book</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="post.php">投稿 <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mypage.php">自分の投稿</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">プロフィール編集</a>
        </li>
      </ul>
      <a class="nav-link" href="logout.php">ログアウト</a>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" enctype="multipart/form-data">
          <legend>投稿</legend>
          <div class="form-group">
            <label for="exampleInputEmail1">タイトル</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="title">
          </div>

          <div class="form-group">
            <label for="exampleTextarea">おすすめポイント</label>
            <input class="form-control" id="exampleTextarea" name="comment">
          </div>

          <div class="form-group">
            <label for="exampleInputFile">写真</label>
            <input type="file" class="form-control-file" id="exampleInputFile" name="picture">
          </div>
          <fieldset class="form-group">
            <button type="submit" class="btn btn-dark">Submit</button>
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