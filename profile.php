<?php 

    require('function.php');
    login_check();
    require('dbconnect.php');

    $sql = 'SELECT * FROM `members` WHERE `member_id` = ?';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $edit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($_POST)) {

    if ($_POST['nickname'] == '') {
    $error['nickname'] = 'blank';
    }
    if ($_POST['introduce'] == '') {
    $error['introduce'] = 'blank';
    }

    if (!isset($error)) {

// 重複チェック
    $sql = 'SELECT COUNT(*) AS `nickname_count` FROM `members` WHERE `nickname` =?';
    $data = array($_POST['nickname']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $nickname_count = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($nickname_count['nickname_count'] >= 1) {
    $error['nickname'] = 'duplicated';
    }

    if (!isset($error)) {

    $nickname = htmlspecialchars($_POST['nickname']);
    $introduce = htmlspecialchars($_POST['introduce']);


    $sql = 'UPDATE `members` SET `nickname` =?, `introduce` =? WHERE `member_id` =?';
    $data = array($nickname,$introduce,$_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    header('Location:Home.php');
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

  <link rel="stylesheet" type="text/css" href="./css/Home.css">


  <!-- fontawesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">

  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
  <script src="js/script.js"></script>

  <title>My Book</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="Home.php" style="font-size: 30px;"><i class="fas fa-anchor"></i>   My Book</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
          <a class="nav-link" href="post.php">投稿 </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mypage.php">自分の投稿</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="profile.php">プロフィール編集<span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <a class="nav-link" href="logout.php">ログアウト</a>
      </form>
    </div>
  </nav>

  <div class="container1">
    <div class="row">
      <div class="col-md-12">
        <legend>プロフィール編集</legend>
        <form action="" method="POST" class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-md-3 control-label">ニックネーム</label>
            <div class="col-md-9">
              <input type="text" name="nickname" class="form-control" value="<?php echo $edit['nickname']; ?>">
              <?php if (isset($error['nickname']) && $error['nickname'] == 'blank') { ?>
                <p class="alert alert-dismissible alert-danger">入力してください。</p>
              <?php } elseif (isset($error['nickname']) && $error['nickname'] == 'duplicated') { ?>
                <p class="alert alert-dismissible alert-danger">既に登録されています。</p>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">自己紹介</label>
            <div class="col-md-9">
              <input type="text" name="introduce" class="form-control" value="<?php echo $edit['introduce']; ?>">
              <?php if (isset($error['introduce']) && $error['introduce'] == 'blank') { ?>
               <p class="alert alert-dismissible alert-danger">入力してください。</p>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-dark" value="編集完了">
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