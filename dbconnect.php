<?php

$dsn = 'mysql:dbname=Book;host=localhost';

// ザンプ環境下では　ユーザー名はroot,パスワードは空
$user = 'root';
$password = '';

// このプログラムが存在している場所と同じサーバーを指定
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->query('SET NAMES utf8');



 ?>