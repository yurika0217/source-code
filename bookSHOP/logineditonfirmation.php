<?php
session_start();
$login_id = $_SESSION['login_id'];
require('function.php');


try {

    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $dbh->prepare("SELECT * FROM users WHERE login_id=:login_id");

    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);

    $stmt->execute();
} catch (PDOException $e) {
    exit('エラー' . $e->getMessage());
}

$row = $stmt->fetch();
include('header.php');

$name = text($_POST['name']);
$post = text($_POST['post']);
$prefecture = $_POST['prefecture'];
$city = text($_POST['city']);
$phone = text($_POST['phone']);
$mail = text($_POST['mail']);
$login_id = text($_POST['login_id']);
$pass = text($_POST['pass']);
$message = [];


try {

    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $dbh->prepare(
        "
    UPDATE users
    SET name=:name, post=:post, prefecture=:prefecture, city=:city, phone=:phone, mail=:mail, pass=:pass
    WHERE login_id=:login_id"
    );

    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':post', $post, PDO::PARAM_STR);
    $stmt->bindParam(':prefecture', $prefecture, PDO::PARAM_STR);
    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
    $stmt->bindParam(':mail', $mail, PDO::PARAM_INT);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);

    $stmt->execute();


    // header('Location: logineditfinish.php');
    // exit();
} catch (PDOException $e) {
    exit('エラー' . $e->getMessage());
}
if ($name === '') {
    $message['name'] = 'お名前が正しくありません。';
}
if ($post === "" || !preg_match('/^(([0-9]{3}-[0-9]{4})|([0-9]{7}))$/', $_POST['post'])) {
    $message['post'] = '郵便番号が正しくありません。';
}
if ($city === "") {
    $message['city'] = '住所(市区町村)が正しくありません。';
}
if ($phone === "" || !preg_match('/^0[0-9]{9,10}\z/', $_POST['phone'])) {
    $message['phone'] = '電話番号が正しくありません。';
}
if ($mail === '') {
    $message['mail'] = 'メールアドレスが正しくありません。';
}
if ($_POST['login_id'] === "" || !preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{6,}+\z/i', $_POST['login_id'])) {
    $message['login_id'] = 'ログインIDが正しくありません';
}
if ($_POST['pass'] === "" || !preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{4,16}+\z/i', $_POST['pass'])) {
    $massage['pass'] = 'パスワードが正しくありません';
}

if (!is_array($message) || !empty($message)) :
    require('edit_error.php');
else :

?>

    <!DOCTYPE html>
    <html lang="ja">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <!-- リセットCSS -->
        <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <div class="mywrapper">

            <div class="content">

                <form action="logineditfinish.php" method="post">
                    <h2>お客様情報変更</h2>
                    <p class="control">名前：<?= $row['name']; ?></p>
                    <p class="control">郵便番号：<?= $row['post']; ?></p>
                    <p class="control">住所(都道府県):<?= $row['prefecture']; ?></p>
                    <p class="control">住所(市区町村):<?= $row['city']; ?></p>
                    <p class="control">電話:<?= $row['phone']; ?></p>
                    <p class="control">メールアドレス：<?= $row['mail']; ?></p>
                    <p class="control">ユーザーID:<?= $row['login_id']; ?></p>
                    <p class="control">パスワード:<?= $row['pass']; ?></p>

                    <p><input type="button" onclick="history.back()" value="キャンセル"><input type="submit" value="完了"></p>
                </form>

            </div>
        </div>
    </body>

    </html>
<?php endif; ?>
<?php

include('footer.php');

?>