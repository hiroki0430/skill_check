<?php 

    require('function.php');
    login_check();
    require('dbconnect.php');

    if (!empty($_GET)) {
      $sql = 'SELECT * FROM `post` WHERE `post_id` =?';
      $data = array($_GET['my_post_id']);
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $post_edit = $stmt->fetch(PDO::FETCH_ASSOC);
      }


     if (!empty($_POST)) {
      if ($_POST['name_edit'] == '') {
        $error['name_edit'] = 'blank';
      }
      if ($_POST['comment_edit'] == '') {
        $error['comment_edit'] = 'blank';
      }

      if (!isset($error)) {

        $ext = substr($_FILES['picture_edit']['name'],-3);
        $ext = strtolower($ext);
        if ($ext == 'jpg' || $ext == 'png' || $ext == 'gif') {
          $picture_edit = date('YmdHis') . $_FILES['picture_edit']['name'];
          move_uploaded_file($_FILES['picture_edit']['tmp_name'], 'picture/'.$picture_edit);
        }

        $name_edit = htmlspecialchars($_POST['name_edit']);
        $comment_edit = htmlspecialchars($_POST['comment_edit']);

        if (!isset($picture_edit)) {
          $picture_edit = $post_edit['post_pic'];
        }

        $sql = 'UPDATE `post` SET `post_name` =?, `post_comment` =?, `post_pic` =?, `modified` =NOW() WHERE `post_id` =?';
        $data = array($name_edit, $comment_edit, $picture_edit, $_GET['my_post_id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: Home.php');
        exit();
    }else{
      header('Location: edit.php');
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

  <title>MY MEMORY</title>
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="Home.php" style="font-size: 30px;"><i class="fas fa-anchor"></i>   MY MEMORY</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="post.php">投稿</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="#">自分の投稿 <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">ログアウト</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <form method="POST" enctype="multipart/form-data">
          <legend>編集</legend>
          <div class="form-group">
            <label for="exampleInputEmail1">タイトル</label>
            <input type="text" class="form-control" name="name_edit" value="<?php echo $post_edit['post_name']; ?>">
            <?php if (isset($error['name_edit']) && $error['name_edit'] == 'blank') { ?>
              <p>入力してください。</p>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="exampleTextarea">おすすめポイント</label>
            <input type="textarea" class="form-control" name="comment_edit" value="<?php echo $post_edit['post_comment']; ?>">
            <?php if (isset($error['comment_edit']) && $error['comment_edit'] == 'blank') { ?>
              <p>入力してください。</p>
            <?php } ?>
          </div>

          <div class="form-group">
            <label for="exampleInputFile">File input</label>
            <input type="file" class="form-control-file" name="picture_edit">
          </div>
          <fieldset class="form-group">
            <button type="submit" class="btn btn-dark">完了</button>
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