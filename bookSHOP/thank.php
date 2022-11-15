<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>新規会員登録完了</title>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet" />
    <link rel="stylesheet" href="user.css">
</head>

<body>
    <?= include('header.php'); ?>
    <div class="content">
        <h1>新規会員登録が完了しました。</h1>
        <p>下のボタンよりログインページに移動してください。</p>
        <br><br>
        <a href="login.php"><button class="btn">ログインページに移動する</button></a>
    </div>
    <?php

    include('footer.php');

    ?>
</body>

</html