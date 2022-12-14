<?php
require("./dbconnect.php");
session_start();

if (!empty($_POST)) {
    /* 入力情報の不備を検知 */
    if ($_POST['login_id'] === "" || !preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{6,}+\z/i', $_POST['login_id'])) {
        $error['login_id'] = "blank";
    }
    if ($_POST['name'] === "") {
        $error['name'] = "blank";
    }
    if ($_POST['pass'] === "" || !preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{4,16}+\z/i', $_POST['pass'])) {
        $error['pass'] = "blank";
    }
    if ($_POST['post'] === "" || !preg_match('/^(([0-9]{3}-[0-9]{4})|([0-9]{7}))$/', $_POST['post'])) {
        $error['post'] = "blank";
    }
    if ($_POST['prefecture'] === "選択して下さい") {
        $error['prefecture'] = "blank";
    }
    if ($_POST['city'] === "") {
        $error['city'] = "blank";
    }
    if ($_POST['phone'] === "" || !preg_match('/^0[0-9]{9,10}\z/', $_POST['phone'])) {
        $error['phone'] = "blank";
    }
    if ($_POST['mail'] === "" || !preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $_POST['mail'])) {
        $error['mail'] = "blank";
    }

    /*idの重複を検知 */
    if (!isset($error)) {
        $admini = $db->prepare('SELECT COUNT(*) as cnt FROM users WHERE login_id=?');
        $admini->execute(array(
            $_POST['login_id']
        ));
        $record = $admini->fetch();
        if ($record['cnt'] > 0) {
            $error['login_id'] = 'duplicate';
        }
    }

    /* エラーがなければ次のページへ */
    if (!isset($error)) {
        $_SESSION['join'] = $_POST;   // フォームの内容をセッションで保存
        header('Location: entry_confirmation.php');   // check.phpへ移動
        exit();
    }
}
$pagetitle = 'ログイン';
include('header.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>新規会員登録</title>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet" />
    <link rel="stylesheet" href="user.css">
</head>

<body>
    <div class="mywrapper">

        <div class="content">
            <form action="entry.php" method="POST">
                <h1>新規会員登録</h1>
                <p>会員項目を操作するために、次のフォームに必要事項をご記入ください。</p>
                <br>
                <div class="control">
                    <label for="id">ID<span class="required">必須</span></label>
                    <input id="id" type="text" name="login_id">
                    <p>&lt;6文字以上・半角英数字&gt; 数字だけにすることはできません</p>
                    <?php if (!empty($error["login_id"]) && $error['login_id'] === 'blank') : ?>
                        <p class="error">IDを入力してください</p>
                    <?php elseif (!empty($error["login_id"]) && $error['login_id'] === 'duplicate') : ?>
                        <p class="error">＊このIDはすでに登録済みです</p>
                    <?php endif ?>
                </div>

                <div class="control">
                    <label for="name">名前<span class="required">必須</span></label>
                    <input id="name" type="name" name="name">
                    <?php if (!empty($error["name"]) && $error['name'] === 'blank') : ?>
                        <p class="error">＊名前を入力してください</p>
                    <?php endif ?>
                </div>

                <div class="control">
                    <label for="pass">パスワード<span class="required">必須</span></label>
                    <input id="pass" type="password" name="pass">
                    <p>&lt;6文字以上16文字以内・半角英数字&gt; 数字だけにすることはできません</p>
                    <?php if (!empty($error["pass"]) && $error['pass'] === 'blank') : ?>
                        <p class="error">＊パスワードが正しくありません。</p>
                    <?php endif ?>
                </div>
                <div class="control">
                    <label for="post">郵便番号<span class="required">必須</span></label>
                    <input id="post" type="post" name="post">
                    <?php if (!empty($error["post"]) && $error['post'] === 'blank') : ?>
                        <p class="error">＊郵便番号が正しくありません。</p>
                    <?php endif ?>
                </div>
                <div class="control">
                    <label>所在地(都道府県)<span class="required">必須</span></label>
                    <select name="prefecture">
                        <option value="選択して下さい" selected>選択して下さい</option>
                        <option value="北海道">北海道</option>
                        <option value="青森県">青森県</option>
                        <option value="岩手県">岩手県</option>
                        <option value="宮城県">宮城県</option>
                        <option value="秋田県">秋田県</option>
                        <option value="山形県">山形県</option>
                        <option value="福島県">福島県</option>
                        <option value="茨城県">茨城県</option>
                        <option value="栃木県">栃木県</option>
                        <option value="群馬県">群馬県</option>
                        <option value="埼玉県">埼玉県</option>
                        <option value="千葉県">千葉県</option>
                        <option value="東京都">東京都</option>
                        <option value="神奈川県">神奈川県</option>
                        <option value="新潟県">新潟県</option>
                        <option value="富山県">富山県</option>
                        <option value="石川県">石川県</option>
                        <option value="福井県">福井県</option>
                        <option value="山梨県">山梨県</option>
                        <option value="長野県">長野県</option>
                        <option value="岐阜県">岐阜県</option>
                        <option value="静岡県">静岡県</option>
                        <option value="愛知県">愛知県</option>
                        <option value="三重県">三重県</option>
                        <option value="滋賀県">滋賀県</option>
                        <option value="京都府">京都府</option>
                        <option value="大阪府">大阪府</option>
                        <option value="兵庫県">兵庫県</option>
                        <option value="奈良県">奈良県</option>
                        <option value="和歌山県">和歌山県</option>
                        <option value="鳥取県">鳥取県</option>
                        <option value="島根県">島根県</option>
                        <option value="岡山県">岡山県</option>
                        <option value="広島県">広島県</option>
                        <option value="山口県">山口県</option>
                        <option value="徳島県">徳島県</option>
                        <option value="香川県">香川県</option>
                        <option value="愛媛県">愛媛県</option>
                        <option value="高知県">高知県</option>
                        <option value="福岡県">福岡県</option>
                        <option value="佐賀県">佐賀県</option>
                        <option value="長崎県">長崎県</option>
                        <option value="熊本県">熊本県</option>
                        <option value="大分県">大分県</option>
                        <option value="宮崎県">宮崎県</option>
                        <option value="鹿児島県">鹿児島県</option>
                        <option value="沖縄県">沖縄県</option>
                    </select>
                    <?php if (!empty($error["prefecture"]) && $error['prefecture'] === 'blank') : ?>
                        <p class="error">＊所在地(都道府県)を選択してください</p>
                    <?php endif ?>
                </div>
                <div class="control">
                    <label for="city">所在地(市区町村／番地)<span class="required">必須</span></label>
                    <input id="city" type="text" name="city">
                    <p>(例)品川区西五反田３－５－２０</p>
                    <?php if (!empty($error["city"]) && $error['city'] === 'blank') : ?>
                        <p class="error">＊所在地(市区町村／番地)を入力してください</p>
                    <?php endif ?>
                </div>
                <div class="control">
                    <label for="o_address">所在地(建物名)</label>
                    <p>(例)○○ビル１１階</p>
                    <input id="o_o_address" type="text" name="o_address">
                </div>
                <div class="control">
                    <label for="phone">電話番号<span class="required">必須</span></label>
                    <input id="phone" type="phone" name="phone">
                    <?php if (!empty($error["phone"]) && $error['phone'] === 'blank') : ?>
                        <p class="error">＊電話番号が正しくありません。</p>
                    <?php endif ?>
                </div>
                <div class="control">
                    <label for="mail">メールアドレス<span class="required">必須</span></label>
                    <input id="mail" type="mail" name="mail">
                    <?php if (!empty($error["mail"]) && $error['mail'] === 'blank') : ?>
                        <p class="error">＊メールアドレスが正しくありません。</p>
                    <?php endif ?>
                </div>

                <div class="control">
                    <button type="submit" class="btn">確認する</button>
                </div>
            </form>
        </div>
    </div>
    <?php

    include('footer.php');

    ?>