<?php

//関数1つに1つの機能のみを持たせる
//1 DBに接続
//2 データを取得する
//3 カテゴリー名を表示する

//1 DBに接続
//引数：なし
//返り値：接続結果を返す
function dbConnect() {
  $dsn = 'mysql:host=localhost;dbname=blog_app;charset=utf8';
  $user = 'blog_user';
  $pass = '8278ab';

  try {
    $dbh = new PDO($dsn, $user,$pass,[
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    } catch(PDOException $e) {
      echo '接続失敗'. $e->getMessage();
      exit();
    };

    return $dbh;
};

//2 データを取得する
//引数：なし
//返り値：取得したデータを返す
function getAllBlog() {
  $dbh = dbConnect();
  // ①SQLの準備
  $sql = 'SELECT * FROM blog';
  // ②SQLの実行
  $stmt = $dbh->query($sql);
  // ③SQLの結果を受け取る
  $result = $stmt->fetchall(PDO::FETCH_ASSOC);
  return $result;
  $dbh = null; 
}

$blogData = getAllBlog();

//3 カテゴリー名を表示する
//引数：数字
//返り値：カテゴリー名
function setCategoryName($category) {
  if ($category === '1') {
      return '日常';
  } elseif ($category === '2') {
      return 'プログラミング';
  } else {
      return 'その他';
  }
}

function getBlog($id){
  
  if(empty($id)) {
    exit('IDが不正です。');
  }
  
  $dbh = dbConnect();
  
  //SQL準備
  $stmt = $dbh->prepare('SELECT * FROM blog Where id = :id');
  $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
  
  //SQL実行
  $stmt->execute();
  //結果を取得
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if(!$result) {
    exit('ブログがありません');
  }

  return $result;
}
?>

