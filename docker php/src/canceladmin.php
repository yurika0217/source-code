<?php
$id = $_POST['id'];
$flg = 1;

try {
    $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
    $user = "root";
    $password = "";

    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $db->prepare(
        "
    UPDATE purdetails LEFT JOIN purchase 
    ON purdetails.pur_id = purchase.id 
    SET purchase.flg = :flg1 ,purdetails.flg = :flg2
    WHERE purdetails.pur_id = :id"
    );

    $stmt->bindParam(':flg1', $flg, PDO::PARAM_INT);
    $stmt->bindParam(':flg2', $flg, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);

    $stmt->execute();

    header('Location: cancelfinish.php');
    exit();
} catch (PDOException $e) {
    exit('エラー' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者キャンセル</title>
</head>

<body>
    <h1>キャンセル受注受付</h1>
    <form action="cancelconfirmation.php" method="POST">
        <input type="hidden" name="is_delate" value="1">
        <input type="submit" value="キャンセル受注">
    </form>
</body>

</html>