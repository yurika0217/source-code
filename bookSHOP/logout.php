<?php
session_start();
$pagetitle = 'ログアウト';
include('header.php');

if (!isset($_SESSION["login_id"])) {
    header("Location: login.php");
    exit();
}

$_SESSION = array();
if (isset($_COOKIE[session_name()]) === true) {
    setcookie(session_name(), "", time() - 42000, "/");
}
session_destroy();
?>
<div class="logout-container">
    <h1>ログアウトが完了しました。</h1>
    <p>ご利用ありがとうございました。</p>
    <a href="index.php">サイトトップへ</a><br>
    <a href="login.php">もう一度ログインする</a>
</div>
<?php

include('footer.php');

?>