<?php
session_start();
$isbn = $_GET['code'];

$dsn = 'mysql:host=localhost;dbname=manga;charset=utf8';
$user = 'root';
$password = '';

try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $db->prepare(
        "
    SELECT * FROM books
    WHERE isbn=:isbn"
    );
    $stmt->bindParam(':isbn', $isbn, PDO::PARAM_INT);

    $stmt->execute();
} catch (PDOException $e) {
    exit('エラー:' . $e->getMessage());
}

$row = $stmt->fetch();
$pagetitle = '検索';
include('header.php');
?>

<div class="sewrapper">

    <figure class="image"><img src="img/<?= $row['img']; ?>" alt="" class="seimg"></figure>
    <div class="right">
        <p class="titl"><?= $row['title']; ?></p>
        <p class="aut">著者：<?= $row['author']; ?></p>
        <p class="is">isbn:<?= $row['isbn']; ?></p>
        <p class="text">あらすじ<br><?= $row['detail']; ?></p>
        <p class="pri"><?= $row['title']; ?>:税込<?= $row['price']; ?>円</p>
        <?php
        if ($row['stock'] > 0) : ?>
            <form action="cart_insert.php" method="post">
                <input type="hidden" name="isbn" value="<?= $row['isbn']; ?>">
                <input type="hidden" name="title" value="<?= $row['title']; ?>">
                <input type="hidden" name="author" value="<?= $row['author']; ?>">
                <input type="hidden" name="publish" value="<?= $row['publish']; ?>">
                <input type="hidden" name="publish_date" value="<?= $row['publish_date']; ?>">
                <input type="hidden" name="count" value="1">
                <input type="hidden" name="price" value="<?= $row['price']; ?>">
                <input type="hidden" name="img" value="<?= $row['img']; ?>">
                <input class="cart-btn" type="submit" value="カートに入れる">
            </form>
        <?php else : ?>
            <input class="out-stock-btn" type="submit" value="在庫切れ">
        <?php endif; ?>
    </div>
</div>
<?php

try {
    $stmt = $db->prepare("SELECT count(*) FROM books
  WHERE category_id = 1");

    $stmt->execute();
} catch (PDOException $e) {
    exit('エラー:' . $e->getMessage());
} ?>
<?php

include('footer.php');

?>