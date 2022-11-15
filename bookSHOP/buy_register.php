<?php
session_start();

$login_id = $_SESSION['login_id'];
$payment = $_POST['payment'];


try {
    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "INSERT INTO purchase (user_id, payment, pur_date)
    VALUES (:user_id, :payment, now())";
    $stmt1 = $dbh->prepare($sql);

    $stmt1->bindParam(':user_id', $login_id, PDO::PARAM_STR);
    $stmt1->bindParam(':payment', $payment, PDO::PARAM_STR);

    $stmt1->execute();
} catch (PDOException $e) {
    exit('エラー：' . $e->getMessage);
}
try {
    $sql = "SELECT * FROM purchase ORDER BY id DESC LIMIT 1";
    $stmt2 = $dbh->prepare($sql);

    $stmt2->execute();
} catch (PDOException $e) {
    exit('エラー：' . $e->getMessage);
}
$row2 = $stmt2->fetch();
foreach ($_SESSION['cart'] as $isbn => $value) {
    try {
        $stmt3 = $dbh->prepare("INSERT INTO purdetails (isbn, pur_id, quantity)
        VALUES (:isbn, :pur_id, :quantity)");

        $stmt3->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt3->bindParam(':pur_id', $row2['id'], PDO::PARAM_INT);
        $stmt3->bindParam(':quantity', $value['count'], PDO::PARAM_INT);

        $stmt3->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
}
$stock = 0;
foreach ($_SESSION['cart'] as $isbn => $value) {
    try {
        $sql = "SELECT stock FROM books WHERE isbn=:isbn ";
        $stmt4 = $dbh->prepare($sql);

        $stmt4->bindParam(':isbn', $isbn, PDO::PARAM_STR);

        $stmt4->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    $row4 = $stmt4->fetch();
    $stock = $row4['stock'] - $value['count'];
    try {
        $sql = "UPDATE books SET stock=:stock WHERE isbn=:isbn";
        $stmt5 = $dbh->prepare($sql);

        $stmt5->bindParam(':isbn', $isbn, PDO::PARAM_STR);
        $stmt5->bindParam(':stock', $stock, PDO::PARAM_STR);

        $stmt5->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
}


header('Location: buy_completion.php');
exit();
