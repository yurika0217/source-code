<?php
$id = $_SESSION['pur_id'];
$purchase_flg = 1;
try {
    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $db->prepare(
        "
    UPDATE purdetails SET purchase_flg=:purchase_flg
    WHERE id=:id"
    );

    $stmt->bindParam(':purchase_flg', $purchase_flg, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    $stmt->execute();

    header('Location: .php');
    exit();
} catch (PDOException $e) {
    exit('エラー' . $e->getMessage());
}
