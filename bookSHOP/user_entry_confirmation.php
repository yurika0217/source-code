<?php
session_start();
include('header.php');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
    <title>確認画面</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet" />
    <link rel="stylesheet" href="user.css">
</head>

<body>
    <div class="content">
        <form action="user_check.php" method="POST">
            <input type="hidden" name="check" value="checked">
            <h1>入力情報の確認</h1>
            <p>ログイン情報に変更が必要な場合、下のボタンを押し、変更を行ってください。</p>
            <p>詳細情報はあとから変更することもできます。</p>
            <?php if (!empty($error) && $error === "error") : ?>
                <p class="error">＊会員登録に失敗しました。</p>
            <?php endif ?>


            <div class="control">
                <p>ID</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['login_id'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>名前</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>郵便番号</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['post'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>所在地(都道府県)</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['prefecture'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>所在地(市区町村／番地)</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['city'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>所在地(建物名)</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['o_address'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>電話番号</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['phone'], ENT_QUOTES); ?></span></p>
            </div>
            <div class="control">
                <p>メールアドレス</p>
                <p><span class="fas fa-angle-double-right"></span> <span class="check-info"><?php echo htmlspecialchars($_SESSION['join']['mail'], ENT_QUOTES); ?></span></p>
            </div>


            <br>
            <a href="user_entry.php" class="back-btn">変更する</a>
            <input type="submit" value="登録する">
            <div class="clear"></div>
        </form>
    </div>
</body>
<?php

include('footer.php');

?>

</html>