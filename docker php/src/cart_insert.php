<?php
session_start();

$isbn = $_POST['isbn'];
$title = $_POST['title'];
$author = $_POST['author'];
$publish = $_POST['publish'];
$publish_date = $_POST['publish_date'];
$count = $_POST['count'];
$price = $_POST['price'];
$img = $_POST['img'];
$ct = 0;

if (isset($_SESSION['cart'][$isbn])) {
    $ct = $_SESSION['cart'][$isbn]['count'];
}
$count += $ct;

$_SESSION['cart'][$isbn] =
    ['title' => $title, 'author' => $author, 'publish' => $publish, 'publish_date' => $publish_date, 'count' => $count, 'price' => $price, 'img' => $img, 'message' => ''];

header('Location: cart.php');
