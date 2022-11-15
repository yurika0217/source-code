<?php
session_start();
 
/* 会員登録の手続き以外のアクセスを飛ばす */
if (!isset($_SESSION['join'])) {
    header('Location: entry.php');
    exit();
}
 
if (!empty($_POST['check'])) {
    // 入力情報をデータベースに登録
try {
        $db = new PDO('mysql:dbname=manga;host=localhost;charset=utf8','root','');

        $stmt = $db->prepare(
            "INSERT INTO users SET login_id=:login_id, name=:name, post=:post, prefecture=:prefecture, city=:city, o_address=:o_address, phone=:phone, mail=:mail, pass=:pass");

        $stmt->bindParam(':login_id', $_SESSION['join']['login_id'], PDO::PARAM_STR);
        $stmt->bindParam(':name', $_SESSION['join']['name'], PDO::PARAM_STR);
        $stmt->bindParam(':post', $_SESSION['join']['post'], PDO::PARAM_STR);
        $stmt->bindParam(':prefecture', $_SESSION['join']['prefecture'], PDO::PARAM_STR);
        $stmt->bindParam(':city', $_SESSION['join']['city'], PDO::PARAM_STR);
        $stmt->bindParam(':o_address', $_SESSION['join']['o_address'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $_SESSION['join']['phone'], PDO::PARAM_STR);
        $stmt->bindParam(':mail', $_SESSION['join']['mail'], PDO::PARAM_STR);
        $stmt->bindParam(':pass', hash('sha256', $_SESSION['join']['pass']), PDO::PARAM_STR);
    
        $stmt->execute();

    }catch (PDOException $e) {
        echo "データベース接続エラー　:".$e->getMessage();
    }

 
    unset($_SESSION['join']);   // セッションを破棄
    header('Location: thank.php');   // thank.phpへ移動
    exit();
}
