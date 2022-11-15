<?php
session_start();
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}
$pagetitle = '購入確定';
include('header.php');
?>
<p>ご注文ありがとうございます</p>
<a href="index.php">トップページへ戻る</a>
<?php

include('footer.php');

?>