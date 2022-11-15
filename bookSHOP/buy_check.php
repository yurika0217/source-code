<?php
session_start();
require('function.php');
if (!isset($_SESSION['login_id'])) {
    header('Location: login.php');
    exit();
}

$login_id = $_SESSION['login_id'];
$message = '';

try {
    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT * FROM users WHERE login_id=:login_id ";
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);

    $stmt->execute();

    $row = $stmt->fetch();
} catch (PDOException $e) {
    exit('エラー：' . $e->getMessage);
}
if (!isset($_POST['payment'])) :
    $message = 'お支払い方法が選択されておりません。';
    require('buy_error.php');
else :
    $pagetitle = 'お客様情報の入力';
    include('header.php');
    $sum_item = 0;
    $sum_price = 0;
?>
    <main class="wrapper">
        <p>ご注文内容の確認</p>
        <p>商品</p>
        <?php
        foreach ($_SESSION['cart'] as $isbn => $value) : ?>
            <img src="img/<?= $value['img']; ?>" alt="">
            <p><?= $value['title']; ?></p>
            <p><?= $value['author']; ?></p>
            <p><?= $value['publish']; ?></p>
            <p>数量 <?= text($value['count']); ?></p>
            <p><?= $value['price']; ?>円</p>
            <p>(税込)</p>
            <?php $sum_item += intval(text($value['count'])); ?>
            <?php $sum_price += intval(text($value['count'])) * intval($value['price']); ?>
        <?php endforeach; ?>
        <a href="cart.php">変更する</a>
        <div>
            <p>お客様情報</p>
            <p><?= text($row['name']); ?> 様宛</p>
            <p>〒<?= text($row['post']); ?></p>
            <p><?= text($row['prefecture'] . $row['city'] . $row['o_address']); ?></p>
            <p>電話番号<?= text($row['phone']); ?></p>
            <p>お支払い方法<?= text($_POST['payment']); ?></p>
            <p>数量合計 <?= $sum_item; ?> 冊</p>
            <p>お支払い合計 <?= number_format($sum_price); ?> 円</p>
            <form action="buy.php" method='post'>
                <input type="submit" value="変更する">
            </form>
        </div>
        <form action="buy_register.php" method="post">
            <input type="hidden" name="payment" value="<?= $_POST['payment']; ?>">
            <input type="submit" value="ご注文を確定">
        </form>
    </main>
<?php endif; ?>
<?php

include('footer.php');

?>