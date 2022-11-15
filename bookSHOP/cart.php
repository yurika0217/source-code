<?php
session_start();
require('function.php');

$pagetitle = '買い物カゴ';
include('header.php');

if (!isset($_SESSION['login_id'])) {
    header('Location: login.php');
    exit();
}

$_SESSION['error'] = '';
$sum_item = 0;
$sum_price = 0;
$message = '';

if (!isset($_SESSION['cart'])) : ?>
    <p>現在、カートには商品がありません。</p>
    <?php else :
    foreach ($_SESSION['cart'] as $isbn => $value) :
        try {
            $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
            $user = "root";
            $password = "";

            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $sql = "SELECT * FROM books WHERE isbn=:isbn ";
            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':isbn', $isbn, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            exit('エラー：' . $e->getMessage);
        }
        $row = $stmt->fetch(); ?>
        <img src="img/<?= $value['img']; ?>" alt="">
        <p><a href="search.php?code=<?= $isbn; ?>"><?= $value['title']; ?></a></p>
        <p><?= $value['author']; ?></p>
        <p><?= $value['publish']; ?></p>
        <p><?= $value['publish_date']; ?></p>
        <p><?= $value['message']; ?></p>
        <!-- カート内数量変更 -->
        <?php
        if ($row['stock'] - $value['count'] < 0) : ?>
            <p>大変申し訳ございませんが、現在在庫が<?= $row['stock']; ?>冊となっております。</p>
        <?php endif; ?>
        <form action="cart_check.php" method="post">
            <input type="text" name="count" maxlength="2" value="<?= text($value['count']); ?>">
            <input type="hidden" name="isbn" value="<?= $isbn; ?>">
            <input type="submit" value="更新">
        </form>
        <!-- カート内アイテム削除 -->
        <form action="cart_delete.php" method='post'>
            <input type="hidden" name="isbn" value="<?= $isbn; ?>">
            <input type="submit" value="削除">
        </form>
        <p><?= number_format($value['price']); ?></p>
        <p>(税込)</p>
        <!-- 合計数量・金額計算計算 -->
        <?php $sum_item += intval(text($value['count'])); ?>
        <?php $sum_price += intval(text($value['count'])) * intval($value['price']); ?>
    <?php endforeach; ?>
    <p>数量合計 <?= $sum_item; ?> 冊</p>
    <p>お支払い合計 <?= number_format($sum_price); ?> 円</p>
    <!-- カートを空にする -->
    <form action="cart_all_delete.php" method='post'>
        <input type="submit" value="カートを空にする">
    </form>
    <!-- 購入手続きに進む -->
    <?php
    foreach ($_SESSION['cart'] as $isbn => $value) :
        if ($row['stock'] - $value['count'] < 0) :
            $message = '在庫数を上回っている商品があります。';
            break;
        endif; ?>
    <?php endforeach; ?>
    <?php
    if (!empty($message)) : ?>
        <p><?= $message; ?></p>
    <?php else : ?>
        <form action="buy.php" method='post'>
            <input type="submit" value="購入手続きに進む">
        </form>
    <?php endif; ?>
<?php endif; ?>

<?php

include('footer.php');

?>