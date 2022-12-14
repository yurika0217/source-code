<?php
session_start();
if (!isset($_SESSION['login_id'])) {
  header('Location: login.php');
  exit();
}

$idd = $_SESSION['login_id'];

$dsn = 'mysql:host = localhost;dbname=manga;charset=utf8';
$user = 'root';
$password = '';

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $stmt = $db->prepare("SELECT*FROM users
      WHERE login_id = '$idd'");

  // $stmt ->bindValue($_SESSION['login_id']);


  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー：' . $e->getMessage());
}
$pagetitle = 'Myページ';
include('header.php');
?>
<div class="mywrapper">

  <div class="content">
    <h2>マイページ</h2>
    <p><b>会員情報</b></p>
    <?php
    while ($row = $stmt->fetch()) {
      echo '<div class="body">';
      echo '<p class="control">ID:', $row['id'], '</p>';
      echo '<p class="control">ユーザーID:', $row['login_id'], '</p>';
      echo '<p class="control">名前：', $row['name'], '</p>';
      echo '<p class="control">郵便番号：', $row['post'], '</p>';
      echo '<p class="control">住所(都道府県):', $row['prefecture'], '</p>';
      echo '<p class="control">住所(市区町村):', $row['city'], '</p>';
      echo '<p class="control">メールアドレス：', $row['mail'], '</p>';
      echo '<p class="control">電話番号：', $row['phone'], '</p>';
      echo '</div>';
    }

    ?>
    <p><a href="loginedit.php">変更</a></p>


    <?php
    // $login_id = $_SESSION['user_id'];

    $num = 5;
    $page = 1;
    if (isset($_GET['page']) && $_GET['page'] > 1) {
      $page = intval($_GET['page']);
    }

    try {
      $db = new PDO($dsn, $user, $password);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      $stmt = $db->prepare("SELECT * FROM purchase 
    LEFT JOIN purdetails ON purchase.id = purdetails.pur_id 
    LEFT JOIN books ON purdetails.isbn = books.isbn 
    WHERE purchase.user_id = :login_id ORDER BY purchase.pur_date DESC LIMIT :page,:num");

      $page = ($page - 1) * $num;

      $stmt->bindParam(':page', $page, PDO::PARAM_INT);
      $stmt->bindParam(':num', $num, PDO::PARAM_INT);

      $stmt->bindParam(':login_id', $_SESSION['login_id'], PDO::PARAM_STR);


      $stmt->execute();
    } catch (PDOException $e) {
      exit('エラー' . $e->getMessage());
    }
    ?>


    <p>購入履歴
      <?php
      while ($row = $stmt->fetch()) {
        echo '<p><img src="img/', $row['img'], '"></p>';
      }
      ?>
      <a href="myhistory.php">購入一覧を表示</a>
    </p>
    <!-- サイドバー -->
    <div class="sidebar">
      <p><a href="withdraewl.php">会員退会</a></p>
      <p><a href="loguout.php">ログアウト</a></p>
    </div>



  </div>
</div>
<!-- サイドバー終了 -->
<?php

include('footer.php');

?>