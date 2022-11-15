<?php
session_start();

if(!preg_match('/^[0-9]*$/', $_POST['count']) || $_POST['count'] === 0):
    $_SESSION['cart'][$_POST['isbn']]['message'] = '数字または0以上の数を入力して下さい。';
    header('Location: cart.php');
    exit();
else:
    $_SESSION['cart'][$_POST['isbn']]['count'] = $_POST['count'];
    $_SESSION['cart'][$_POST['isbn']]['message'] = '';
    header('Location: cart.php');
    exit();
endif;
