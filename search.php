<?php 

    require('function.php');
    login_check();
    require('dbconnect.php');

    $recommends = array();

    if (!empty($_GET['search_key'])&&isset($_GET['search_key'])) {

      $sql = "SELECT `post`. * , `members`. `nickname` FROM `post` LEFT JOIN `members` on `post` . `member_id` = `members` . `member_id` WHERE `members` . `nickname` LIKE '%" . $_GET['search_key'] . "%' OR `post`.`post_name` LIKE '%" . $_GET['search_key'] . "%' OR `post`.`post_comment` LIKE '%" . $_GET['search_key'] . "%' ORDER BY `post` . `created` DESC";


    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while (true) {
      $recommend = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($recommend == false) {

        break;
      }
      $recommends[] = $recommend;
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
          <a class="nav-link" href="post.php">投稿</a>
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
      <form class="form-inline my-2 my-lg-0">
        <a class="nav-link" href="logout.php">ログアウト</a>
      </form>
    </div>
  </nav>

  <div>
    <?php foreach ($recommends as $review ) { ?>
      <div class="col-sm-4">
         <div class="card" style="width: 18rem;">
          <img class="card-img-top" src="picture/<?php echo $review['post_pic'];?>" >
          <div class="card-body">
            <h5 class="card-title"><?php echo $review['post_name']; ?></h5>
            <a href="detail.php?detail_button=<?php echo $review['post_id'] ?>" class="btn btn-dark">詳細をみる</a>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if (count($recommends)==0) : ?>
      <h1>ないぜよ</h1>
    <?php endif ;?>
  </div>


  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</body>
</html>