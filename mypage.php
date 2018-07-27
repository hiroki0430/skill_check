<?php
    require('function.php');
    login_check();
    require('dbconnect.php');

    $sql = 'SELECT * FROM `post` WHERE `member_id` = ?';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $my_posts = array();

    while (true) {
      $my_post = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($my_post == false) {
        break;
      }
      $my_posts[] = $my_post;
    }
    $count = count($my_posts);

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
    <a class="navbar-brand" href="home.php" style="font-size: 30px;"><i class="fas fa-anchor"></i>   My Book</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="post.php">投稿</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="mypage.php">自分の投稿<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">プロフィール編集</a>
        </li>
      </ul>
      <a class="nav-link" href="logout.php">ログアウト</a>
    </div>
  </nav>

  <div class="form-group">
    <div class="container">
      <div class="row">
        <?php for ($i=0; $i < count($my_posts); $i++) { ?>
          <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
              <div class="caption">
                <img class="card-img-top" width="300" height="400" src="picture/<?php echo $my_posts[$i]['post_pic'];?>" >
                <h3><?php echo $my_posts[$i]['post_name']; ?></a></h3>
                <p><?php echo $my_posts[$i]['post_comment']; ?></p>
                <p><?php echo date('Y/m/d', strtotime($my_posts[$i]['created']));?></p>

                <a href="edit.php?my_post_id=<?php echo $my_posts[$i]['post_id'] ?>" class="btn btn-dark">編集</a>
                <a href="delete.php?my_post_id=<?php echo $my_posts[$i]['post_id'] ?>" class="btn btn-danger"" onclick="return confirm('really?');">削除</a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>