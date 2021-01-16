<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style rel="stylesheet" type="text/css">
  
  body {
    padding: 20px;
    text-align: center;
  }

  h1 {
    margin-bottom: 20px;
    padding: 20px 0;
    color: #209eff;
    font-size: 122%;
    border-top: 1px solid #999;
    border-bottom: 1px solid #999;
  }

  </style>

  <title>送信完了ページ</title>
</head>
<body>

<h1>送信が完了しました。</h1>
  
</body>
</html>

<?php

require_once('funcs.php');

$name = $_POST['your_name'];
$email = $_POST['email'];
$age = $_POST['age'];
$text = $_POST['text'];

//DB接続
$pdo = db_con();

//データ登録SQL作成

// 1. SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, name, email, age, text, indate)VALUES(NULL, :name, :email, :age, :text, sysdate())");
//  2. バインド変数
$stmt->bindValue(':name', h($name), PDO::PARAM_STR); 
$stmt->bindValue(':email', h($email), PDO::PARAM_STR); 
$stmt->bindValue(':age', h($age), PDO::PARAM_INT);
$stmt->bindValue(':text', h($text), PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

if($status == false){
  sql_error($stmt);

}else{

  //変数とタイムゾーンの初期化
  $reply_subject = null;
  $reply_text = null;
  date_default_timezone_set('Asia/Tokyo');

  //件名の設定
  $reply_subject = 'お問合せありがとうございました。';
  
  //本文の設定
  $reply_text = h($name)."様\n"."この度は、お問い合わせ頂き誠にありがとうございます。\n\n";
  $reply_text .= "お問合せ日時: ". date("Y-m-d H:i") ."\n";
  $reply_text .= "メールアドレス: ". h($email) ."\n";
  $reply_text .= "ご年齢: ". h($age) ."\n";
  $reply_text .= "お問合せ内容: ". h($text) ."\n";
  
  //自動メール送信関数
  mb_send_mail( $email, $reply_subject, $reply_text);


}



?>

