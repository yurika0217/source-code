<?php
session_start();

$isbn = $_POST['isbn'];
if (isset($_SESSION['cart'][$isbn])) {
    unset($_SESSION['cart'][$isbn]);
    if ($_SESSION['cart'] === []) {
        unset($_SESSION['cart']);
    }
}
header('Location: cart.php');
exit();
