<?php
$isbn = '978-4-06-528768-2';
try {
    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "SELECT stock FROM books WHERE isbn=:isbn ";
    $stmt3 = $dbh->prepare($sql);

    $stmt3->bindParam(':isbn', $isbn, PDO::PARAM_STR);


    $stmt3->execute();
} catch (PDOException $e) {
    exit('エラー：' . $e->getMessage);
}
$row3 = $stmt3->fetch();
var_dump($row3['stock']);
