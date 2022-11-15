<?php
session_start();
$pagetitle = 'ログイン';
include('header.php');
require('function.php');
if (isset($_SESSION["login_id"])) {
    header("Location: index.php");
    exit();
}

if (count($_POST) === 0) {
    $message = "";
} else {
    if ($_POST["login_id"] === '' || $_POST["pass"] === '') {
        $message = "ユーザー名とパスワードを入力してください";
    } else {
        try {
            $login_id = $_POST['login_id'];
            $pass = $_POST['pass'];
            $flg = 0;

            $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
            $user = "root";
            $password = "";

            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $sql = 'SELECT * FROM users WHERE login_id=:login_id AND pass=:pass AND flg=:flg';
            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':login_id', $_POST['login_id'], PDO::PARAM_STR);
            $stmt->bindParam(':pass', hash('sha256', $_POST['pass']), PDO::PARAM_STR);
            $stmt->bindParam(':flg', $flg, PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            exit('エラー：' . $e->getMessage());
        }
        if ($rec = $stmt->fetch()) {
            $_SESSION['id'] = $rec['id'];
            $_SESSION['login_id'] = $rec['login_id'];
            $_SESSION['name'] = $rec['name'];
            header('Location: index.php');
            exit();
        } else {
            $message = "ユーザー名かパスワードが違います";
        }
    }
}
?>
<div class="logwrapper">

    <div class="loginbody">
        <h1 class="logintitle">ログインページ</h1>
        <div><?= $message; ?></div>
        <form action="login.php" method="post">
            <p class="loginpass">ログインID　　
                <input type="text" name="login_id" class="logtext" style="font-size:20px;">
            </p>
            <p class="loginpass">パスワード　　
                <input type="password" name="pass" class="logtext" style="font-size:20px;">
            </p><br>
            <input type="submit" value="ログイン" class="logbottom">
        </form>
    </div>
</div>
<?php

include('footer.php');

?>