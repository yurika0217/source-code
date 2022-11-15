<?php
session_start();

$num = 5;

$dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
$user = "root";
$password = "";

$page = 1;
if (isset($_GET['page']) && $_GET['page'] > 1) {
  $page = intval($_GET['page']);
}

try {

  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $stmt = $db->prepare("SELECT * FROM books
  -- AND flg=0
ORDER BY publish_date DESC LIMIT :page,:num");

  $page = ($page - 1) * $num;

  $stmt->bindParam(':page', $page, PDO::PARAM_INT);
  $stmt->bindParam(':num', $num, PDO::PARAM_INT);

  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー：' . $e->getMessage());
}
$pagetitle = '新着コミック';
include('header.php');
?>
<div class="wrapper">
  <h2 class="category">新着</h2>
  <?php
  while ($row = $stmt->fetch()) {
    $sql_date = strtotime($row['publish_date']);
    $publish_date = date('YmdHis', $sql_date);
    $dateymd = date('Y-m-d', $sql_date);
    $today = date("YmdHis");
    if ($publish_date >= $today - 200000000) {
      echo "<div class=new>";
      echo "new";
      echo "</div>";
    } ?><br /><?php
                echo '<div class="cate_in">';
                echo '<a href= "search.php?code=' . $row['isbn'] . '"><img class="catephoto" src="img/', $row['img'], '"></a>';
                echo '<h4 class="catetitle"><a href= "search.php?code=' . $row['isbn'] . '"class="categorytitle">' . $row['title'] . '</a></h4>';
                echo '<p class="cateprice">価格：税込', $row['price'], '円</p>';
                echo '<a href="searchresult.php?search=' . $row['author'] . '"><p class="cateaut">著者：', $row['author'], '</p></a>';
                echo '<a href="searchresult.php?search=' . $row['publish'] . '"><p class="catepub">出版社：', $row['publish'], '</p></a>';
                echo '<p class="catedate">発売日：', $dateymd, '</p>'; ?>
    <form action="cart_insert.php" method="post" class="cartin">
      <input type="hidden" name="isbn" value="<?= $row['isbn']; ?>">
      <input type="hidden" name="title" value="<?= $row['title']; ?>">
      <input type="hidden" name="author" value="<?= $row['author']; ?>">
      <input type="hidden" name="publish" value="<?= $row['publish']; ?>">
      <input type="hidden" name="publish_date" value="<?= $row['publish_date']; ?>">
      <input type="hidden" name="count" value="1">
      <input type="hidden" name="price" value="<?= $row['price']; ?>">
      <input type="hidden" name="img" value="<?= $row['img']; ?>">
      <input type="submit" value="カートに入れる">
</div>
</form>
<hr>
<?php
  } ?>
</div>
<?php


try {
  $stmt = $db->prepare("SELECT count(*) FROM books");

  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー:' . $e->getMessage());
}
$comments = $stmt->fetchColumn();
$max_page = ceil($comments / $num);

if ($max_page >= 1) {
  echo '<nav><ul class="pagination">';
  for ($i = 1; $i <= $max_page; $i++) {
    echo '<li class="page-item"><a href="newitem.php?page=' . $i . '">' . $i . '</a></li>';
  }
  echo '</ul></nav>';
}

?>
<?php

include('footer.php');

?>