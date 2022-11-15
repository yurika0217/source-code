<?php
session_start();
require('function.php');
$num = 5;

$data = '';
if (isset($_GET['search'])) {
  $data = $_GET['search'];
}

$search = text('%' . $data . '%');

$page = 1;
if (isset($_GET['page']) && $_GET['page'] > 1) {
  $page = intval($_GET['page']);
}

$dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
$user = "root";
$password = "";

try {
  $db = new PDO($dsn, $user, $password);
  $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

  $stmt = $db->prepare("SELECT * FROM books WHERE title LIKE :search1 OR publish LIKE :search2 OR author LIKE :search3 OR author_kana LIKE :search4 LIMIT :page,:num");

  $page = ($page - 1) * $num;
  $stmt->bindParam(':page', $page, PDO::PARAM_INT);
  $stmt->bindParam(':num', $num, PDO::PARAM_INT);
  $stmt->bindParam(':search1', $search, PDO::PARAM_STR);
  $stmt->bindParam(':search2', $search, PDO::PARAM_STR);
  $stmt->bindParam(':search3', $search, PDO::PARAM_STR);
  $stmt->bindParam(':search4', $search, PDO::PARAM_STR);

  $stmt->execute();
} catch (PDOException $e) {
  exit('エラー：' . $e->getMessage());
}

$pagetitle = '検索結果';

include('header.php');

?>
<div>
  <h1 class="searchresult">
    <?php if ($data != '') : ?>
      "<?= $data; ?>"を含む検索結果
    <?php else : ?>
      商品一覧
    <?php endif; ?>
  </h1>

  <?php
  while ($row = $stmt->fetch()) :
  ?>

    <a href="search.php?cord=<?= $row['isbn']; ?>"></a>
    <div class="wrapper">
      <div class="cate_in">
        <div class="searchresultphoto">
          <a href="search.php?code=<?= $row['isbn']; ?>"><img class="catephoto" src="img/<?= $row['img']; ?>"></a>
        </div>
        <div class="searchresulttext">
          <a href="search.php?code=<?= $row['isbn']; ?>">
            <p class="catetitle"><?= $row['title']; ?></p>
          </a>
          <p class="cateaut">著　者：<a href="searchresult.php?search=<?= $row['author']; ?>"><?= $row['author']; ?></a></p>
          <p class="cateprice"><span>価　格：税込</span><?= $row['price']; ?>円</p>
          <p class="catepub">出版社：<a href="searchresult.php?search=<?= $row['publish']; ?>"><?= $row['publish']; ?></a></p>
          <p class="catedate">発売日：<?= $row['publish_date']; ?></p>
        </div>
        <form action="cart_insert.php" method="post" class="cartin">
          <input type="hidden" name="isbn" value="<?= $isbn; ?>">
          <input type="hidden" name="title" value="<?= $title; ?>">
          <input type="hidden" name="author" value="<?= $author; ?>">
          <input type="hidden" name="publish" value="<?= $publish; ?>">
          <input type="hidden" name="publish_date" value="<?= $publish_date; ?>">
          <input type="hidden" name="count" value="1">
          <input type="hidden" name="price" value="<?= $price; ?>">
          <input type="hidden" name="img" value="<?= $img; ?>">
          <input type="submit" value="カートに入れる">
      </div>
      </form>
      <hr>
    </div>

  <?php endwhile; ?>

  <?php
  try {
    $stmt = $db->prepare("SELECT count(*) FROM books WHERE title LIKE :search1 OR publish LIKE :search2 OR author LIKE :search3 OR author_kana LIKE :search4");
    $stmt->bindParam(':search1', $search, PDO::PARAM_STR);
    $stmt->bindParam(':search2', $search, PDO::PARAM_STR);
    $stmt->bindParam(':search3', $search, PDO::PARAM_STR);
    $stmt->bindParam(':search4', $search, PDO::PARAM_STR);
    $stmt->execute();
  } catch (PDOException $e) {
    exit('エラー：' . $e->getMessage());
  }
  $comments = $stmt->fetchColumn();
  $max_page = ceil($comments / $num);
  if ($max_page >= 1) : ?>
    <nav>
      <ul class="pagination">
        <?php for ($i = 1; $i <= $max_page; $i++) : ?>
          <li class="page-item">
            <a href="searchresult.php?search=<?= $_GET['search']; ?>&page=<?= $i; ?>"><?= $i; ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>
  <?php endif; ?>

</div>
</main>
<?php

include('footer.php');

?>