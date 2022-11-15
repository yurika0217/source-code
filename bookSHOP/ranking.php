<?php
session_start();
require('function.php');
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

  $stmt = $db->prepare('SELECT books.isbn, title, price, stock, publish_date, author, publish, img, SUM(quantity) FROM books 
JOIN purdetails ON books.isbn = purdetails.isbn WHERE books.flg=0 group by books.isbn ORDER BY SUM(quantity) DESC LIMIT :page,:num');

  $page = ($page - 1) * $num;
  $stmt->bindParam(':page', $page, PDO::PARAM_INT);
  $stmt->bindParam(':num', $num, PDO::PARAM_INT);

  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー：' . $e->getMessage());
}
$pagetitle = 'ランキング';
include('header.php');
?>
<div class="wrapper">
  <h2 class="category">ランキング</h2>
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
                echo '<a href= "search.php?code=' . text($row['isbn']) . '"><img img class="catephoto" src="img/', $row['img'], '"></a>';
                echo '<h4 class="catetitle"><a href= "search.php?code=' . text($row['isbn']) . '">' . $row['title'] . '</a></h4>';
                echo '<p class="cateprice">価　格：税込', $row['price'], '円</p>';
                ?><p class="cateaut">著　者：<a href="searchresult.php?search=<?= $row['author']; ?>"><?= $row['author']; ?></a></p><?php
                                                                                                                  ?><p class="catepub">出版社：<a href="searchresult.php?search=<?= $row['publish']; ?>"><?= $row['publish']; ?></a></p><?php
                                                                                                                    echo '<p class="catedate">発売日：', $dateymd, '</p>'; ?>
    <?php
    if ($row['stock'] > 0) : ?>
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
<?php else : ?>
  <p>在庫切れ</p>
<?php endif; ?>
<hr>

<?php
  } ?>
</div>
<?php

try {
  $stmt = $db->prepare("SELECT * FROM books 
  JOIN purdetails ON books.isbn = purdetails.isbn WHERE books.flg=0 GROUP BY books.isbn");

  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー:' . $e->getMessage());
}
$comments = $stmt->fetchColumn();
$max_page = ceil($comments / $num);


if ($max_page >= 1) {
  echo '<nav><ul class="pagination">';
  for ($i = 1; $i <= $max_page; $i++) {
    echo '<li class="page-item"><a href="ranking.php?page=' . $i . '">' . $i . '</a></li>';
  }
  echo '</ul></nav>';
}

?>
<?php

include('footer.php');

?>