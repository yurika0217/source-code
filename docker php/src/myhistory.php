<?php

$num = 5;

session_start();
if (!isset($_SESSION['login_id'])) {
  header('Location: login.php');
  exit();
}

$login_id = $_SESSION['login_id'];

$page = 1;
if (isset($_GET['page']) && $_GET['page'] > 1) {
  $page = intval($_GET['page']);
}

try {

  $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
  $user = "root";
  $password = "";

  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $stmt = $db->prepare("SELECT id FROM purchase 
  WHERE user_id = :login_id AND flg = 0 LIMIT :page, :num");

  $page = ($page - 1) * $num;

  $stmt->bindParam(':page', $page, PDO::PARAM_INT);
  $stmt->bindParam(':num', $num, PDO::PARAM_INT);
  $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);

  $stmt->execute();

  $stmt1 = $db->prepare("SELECT id FROM purchase 
  WHERE user_id = :login_id AND flg = 0 LIMIT :page, :num");

  $stmt1->bindParam(':page', $page, PDO::PARAM_INT);
  $stmt1->bindParam(':num', $num, PDO::PARAM_INT);
  $stmt1->bindParam(':login_id', $login_id, PDO::PARAM_STR);

  $stmt1->execute();
} catch (PDOException $e) {
  exit('エラー' . $e->getMessage());
}

$row = $stmt->fetchColumn()
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>購入履歴一覧</title>
</head>

<body>
  <h1>購入履歴一覧</h1>
  <?php if ($row > 0) {
  ?>
    <table>
      <thead>
        <tr>
          <th>商品画像</th>
          <th>購入日時</th>
          <th>商 品 名</th>
          <th>購 入 数</th>
          <th>購入金額</th>
          <th>支払方法</th>
          <th>購入明細</th>
          <th>キャンセル</th>
        </tr>
      </thead>
      <tbody>
        <?php
        while ($row = $stmt1->fetch()) :
          try {
            $stmt2 = $db->prepare("SELECT * FROM purchase 
            JOIN purdetails ON purchase.id = purdetails.pur_id 
            JOIN books ON purdetails.isbn = books.isbn 
            WHERE purchase.id = :id ORDER BY purchase.pur_date desc");

            $stmt2->bindParam(':id', $row['id'], PDO::PARAM_INT);

            $stmt2->execute();
          } catch (PDOException $e) {
            exit('エラー' . $e->getMessage());
          }
          while ($row2 = $stmt2->fetch()) : ?>

            <tr>
              <td>
                <h4><a href="search.php?code=<?= $row2['isbn']; ?>"><img src="img/<?= $row2['img']; ?>"></a>
              </td>
              <td><?php echo ($row2['pur_date']); ?></td>
              <?php $pur_date = $row2['pur_date']; ?>
              <td><a href="search.php?code=<?= $row2['isbn']; ?>"><?php echo ($row2['title']); ?><a></td>
              <td><?php echo $row2['quantity']; ?>
              <td><?php echo "税込" . ($row2['price'] * $row2['quantity']) . "円"; ?></td>
              <td><?php echo ($row2['payment']); ?></td>
              <td>
              <?php endwhile; ?>
              <form action="myhistorypreview.php" method="post">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="pur_date" value="<?= $pur_date; ?>">
                <input type="submit" value="購入明細表示">
              </form>
              </td>
              <td>
                <form action="canceladmin.php" method="post">
                  <input type="hidden" name="id" value="<?= $row['id']; ?>">
                  <input type="submit" value="キャンセル">
                </form>
              </td>
            <?php endwhile; ?>
            </tr>
      </tbody>
    </table>
  <?php } else { ?>
    <p>購入履歴がありません。</p>
  <?php }; ?>
  <?php

  try {
    $stmt3 = $db->prepare("SELECT COUNT(*) FROM purchase 
  WHERE user_id = :login_id AND flg = 0 ");

    $stmt3->bindParam(':login_id', $login_id, PDO::PARAM_STR);

    $stmt3->execute();
  } catch (PDOException $e) {
    exit('エラー' . $e->getMessage());
  }

  $row3 = $stmt3->fetchColumn();
  $max_page = ceil($row3 / $num);

  if ($max_page >= 1) {
    echo '<nav><ul class="pagination">';
    for ($i = 1; $i <= $max_page; $i++) {
      echo '<li class="page-item"><a href="myhistory.php?page=' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul></nav>';
  }
  ?>
</body>

</html>

<?php include('footer.php'); ?>