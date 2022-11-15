<?php
session_start();

$login_id = $_SESSION['login_id'];
$flg = 1;
try {
    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $db->prepare("
    UPDATE users SET flg=1
    WHERE login_id=:login_id");

    // $stmt->bindParam(':flg', $flg, PDO::PARAM_INT);
    $stmt->bindParam(':login_id', $login_id, PDO::PARAM_STR);

    $stmt->execute();
} catch (PDOException $e) {
    exit('エラー' . $e->getMessage());
}

if (isset($_SESSION['login_id'])) {
    unset($_SESSION['login_id']);
    header('Location: withdraewlfinish.php');
    exit();
}
