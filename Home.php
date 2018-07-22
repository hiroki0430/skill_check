<?php

    session_start();
    require('dbconnect.php');

    $sql = 'SELECT * FROM `post` WHERE `post_id`';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $book_info = array();

    while (true) {
      $book_info = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($book_info == false) {
        break;
      }
      $books_info[] = $book_info;
      }

      $count = count($books_info);

      // echo('<pre>');
      // var_dump($books_info);die();
      // echo('</pre>');

// ページング機能
      $page = '';

      if (isset($_GET['page'])) {
        $page = $_GET['page'];
      }else{
        $page = 1;
      }
      $page = max($page, 1);
      $page_number = 6;

      $page_sql = 'SELECT COUNT(*) AS `page_count` FROM `post` WHERE `created`<NOW()';
      $page_stmt = $dbh->prepare($page_sql);
      $page_stmt->execute();
      $page_count = $page_stmt->fetch(PDO::FETCH_ASSOC);

      $all_page_number = ceil($page_count['page_count'] / $page_number);

      $page = min($page, $all_page_number);
      $start = ($page - 1) * $page_number;


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
    <a class="navbar-brand" href="#" style="font-size: 30px;"><i class="fas fa-anchor"></i>   My Book</a>
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
        <li class="nav-item">
          <a class="nav-link" href="profile.php">プロフィール編集</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <a class="nav-link" href="logout.php">ログアウト</a>
      </form>
    </div>
  </nav>
  <div class="jumbotron">
    <img src="pic/IMG_3233.jpg" alt="" width="1500" height="700" >
    <h1 class="display-3"><i class="fas fa-book"></i></h1>
    <p class="lead">あなたのおすすめの本をみんなに紹介しよう。<br>使い方はカンタン！投稿ボタンを押して入力画面に進もう。</p>
  </div>



  <div class="container">
    <div class="row">
      <?php for ($i=0; $i < count($books_info); $i++) { ?>
        <div class="col-sm-4">
         <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="picture/<?php echo $books_info[$i]['post_pic'];?>" >
          <div class="card-body">
            <h5 class="card-title"><?php echo $books_info[$i]['post_name']; ?></h5>
            <a href="detail.php?detail_button=<?php echo $books_info[$i]['post_id'] ?>" class="btn btn-dark">詳細をみる</a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <!-- 最初のページの時、"前"のボタンを押せないようにする -->
                <?php if($page == 1) { ?>
                  <li>前</li>
                <?php } else { ?>
                  <li><a href="Home.php?page=<?php echo $page -1; ?>" class="btn btn-default">前</a></li>
                <?php } ?>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <!-- 最後のページの時、"次"のボタンを押せないようにする -->
                <?php if($page == $all_page_number) { ?>
                  <li>次</li>
                <?php } else {  ?>
                  <li><a href="Home.php?page=<?php echo $page +1; ?>" class="btn btn-default">次</a></li>
                <?php } ?>
                <!-- 現在のページ / 最大のページ -->
                <li><?php echo $page; ?> / <?php echo $all_page_number; ?></li>
          </ul>








<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>