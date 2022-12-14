<?php

session_start();
if (!isset($_SESSION['login_id'])) {
  header('Location: login.php');
  exit();
}

$login_id = $_SESSION['login_id'];

$preview_id = $_POST['id'];
$preview_pur_date = $_POST['pur_date'];

try {
  $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
  $user = "root";
  $password = "";

  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $stmt = $db->prepare("SELECT * FROM purchase 
  LEFT JOIN purdetails ON purchase.id = purdetails.pur_id 
  LEFT JOIN books ON purdetails.isbn = books.isbn 
  WHERE purchase.user_id = :login_id AND purchase.id = :preview_id ORDER BY purchase.pur_date desc");

  $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
  $stmt->bindParam(':preview_id', $preview_id, PDO::PARAM_STR);

  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>購入明細</title>
</head>

<body>
  <h1>購入明細</h1>

  <?php echo "注文番号：" . $preview_id; ?><br />
  <?php echo "注文番号：" . $preview_pur_date; ?><br />

  <?php while ($row = $stmt->fetch()) : ?>
    <?php $sql_date = strtotime($row['publish_date']);
    $publish_date = date('YmdHis', $sql_date);
    $dateymd = date('Y-m-d', $sql_date); ?>
    <h4><a href="search.php?code=<?= $row['isbn']; ?>"><img src="img/<?= ($row['img']); ?>"></a><br />
      <?php echo "商品名　：" ?><a href="search.php?code=<?= ($row['isbn']); ?>"><?php echo ($row['title']); ?><a><br />
          <?php echo "著　者　：" ?><a href="searchresult.php?search=<?= ($row['author']); ?>"><?php echo ($row['author']); ?></a><br />
          <?php echo "ISBN　 ：" . ($row['isbn']); ?><br />
          <?php echo "出版社　：" ?><a href="searchresult.php?search=<?= ($row['publish']); ?>"><?php echo ($row['publish']); ?></a><br />
          <?php echo "発売日　：" . ($dateymd); ?><br />
          <?php echo "購入数　：" . ($row['quantity']); ?><br />
          <?php echo "購入金額：税込" . ($row['price'] * $row['quantity']) . "円"; ?><br />
        <?php endwhile; ?>
        <br />
        <?php echo '<a href="' . $_SERVER['HTTP_REFERER'] . '">購入履歴一覧に戻る</a>';
        ?>

</body>

</html>

<?php include('footer.php'); ?>