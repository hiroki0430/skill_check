
<?php

    require('function.php');
    login_check();
    require('dbconnect.php');

    // ページング機能
      $page = '';

      if (isset($_GET['page'])) {
        $page = $_GET['page'];
      }else{
        $page = 1;
      }
      $page = max($page, 1);
      $page_number = 6;
// ここでデータをあるだけ取得してる。
      $page_sql = 'SELECT COUNT(*) AS `page_count` FROM `post` WHERE `created`<NOW()';
      $page_stmt = $dbh->prepare($page_sql);
      $page_stmt->execute();
      $page_count = $page_stmt->fetch(PDO::FETCH_ASSOC);

      // var_dump($page_count);die();

      $all_page_number = ceil($page_count['page_count'] / $page_number);

      $page = min($page, $all_page_number);
      $start = ($page - 1) * $page_number;

// ここで１ページあたり何件のデータを表示させるかの処理してる。limit どこから？, 何件取得？　＄を''の中に入れると変数展開できないので、外に出してあげよう。

    $sql = 'SELECT * FROM `post` WHERE `post_id` limit '. $start . ', ' . $page_number;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $book_info = array();

    while (true) {
      $book_info = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($book_info == false) {
        break;
      }
      // $books_info[] = $book_info;
      
// echo "<pre>";
// var_dump($book_info);die();
// echo "</pre>";

// $book_info には１件の投稿データが入っている。


// like数を取得
    $like_sql = 'SELECT COUNT(*) as `like_count` FROM `likes` WHERE `post_id`=?';
    $like_data = array($book_info['post_id']);
    $like_stmt = $dbh->prepare($like_sql);
    $like_stmt->execute($like_data);
    $like_count = $like_stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($like_count); die;

    $book_info['like_count'] = $like_count['like_count'];

    $login_like_sql = 'SELECT COUNT(*) as `login_count` FROM `likes` WHERE `member_id`= ? AND `post_id`=?';
    $login_like_data = array($_SESSION['id'],$book_info['post_id']);
    $login_like_stmt = $dbh->prepare($login_like_sql);
    $login_like_stmt->execute($login_like_data);

    $login_like_number = $login_like_stmt->fetch(PDO::FETCH_ASSOC);

    $book_info['login_like_flag'] = $login_like_number['login_count'];

    $book_info_list[] = $book_info;

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
      <form class="form-inline my-2 my-lg-0" method="GET" action="search.php" >
      <input class="form-control mr-sm-2" type="search" aria-label="Search" name="search_key">
      <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
    </form>
    <a class="nav-link" href="logout.php">ログアウト</a>
    </div>
  </nav>

  <div class="jumbotron">
    <h1 class="display-3"><i class="fas fa-book"></i></h1>
    <p class="lead">あなたのおすすめの本をみんなに紹介しよう。<br>使い方はカンタン！投稿ボタンを押して入力画面に進もう。</p>
  </div>

  <div class="container">
    <div class="row">
      <?php foreach ($book_info_list as $one_book_info) { ?>
        <div class="col-sm-4">
         <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="picture/<?php echo $one_book_info['post_pic'];?>" >
          <div class="card-body">
            <h5 class="card-title"><?php echo $one_book_info['post_name']; ?></h5>
            <a href="detail.php?detail_button=<?php echo $one_book_info['post_id'] ?>" class="btn btn-dark">詳細をみる</a>
            <?php if ($one_book_info['login_like_flag'] == 0) { ?>
            <a href="like.php?like_book_id=<?php echo $one_book_info['post_id'] ?>&page=<?php echo $page; ?>" class="btn btn-primary"><i class="fas fa-bell"></i></a>
            <?php } else { ?>
            <a href="like.php?unlike_book_id=<?php echo $one_book_info['post_id'] ?>&page=<?php echo $page; ?>" class="btn btn-danger"><i class="fas fa-bell-slash"></i></a>
            <?php } ?>
            <span><i class="fas fa-map-marker-smile"></i><br>いいね：<?php echo $one_book_info['like_count'] ?></span>
          </div>
        </div>
      </div>

    <?php } ?>

    <ul class="mx-auto" style="margin-top: 100px;">
                &nbsp;&nbsp;&nbsp;&nbsp;
                <!-- 最初のページの時、"前"のボタンを押せないようにする -->
                <?php if($page == 1) { ?>
                <?php } else { ?>
                  <a href="Home.php?page=<?php echo $page -1; ?>" class="btn btn-dark">前</a>
                <?php } ?>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <!-- 最後のページの時、"次"のボタンを押せないようにする -->
                <?php if($page == $all_page_number) { ?>
                  次
                <?php } else {  ?>
                  <a href="Home.php?page=<?php echo $page +1; ?>" class="btn btn-dark">次</a>
                <?php } ?>
                <!-- 現在のページ / 最大のページ -->
                <?php echo $page; ?> / <?php echo $all_page_number; ?>
          </ul>
  </div>
</div>



<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>