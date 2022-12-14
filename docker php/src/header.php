<!doctype html>
<html>

<head>
  <meta charset="UTF-8">
  <!-- <meta name="description" content=""> -->
  <title>honto - <?= $pagetitle; ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <!-- ヘッダー -->
  <header class="header">
    <div class="wrapper">
      <div class="header-container">
        <div class="header-logo">
          <h1><a href="index.php"><img src="img/logo.webp" alt="メインロゴ"></a></h1>
        </div>
        <!--header-logo-->
        <div class="header-search">
          <form class="search-form" action="searchresult.php" method="get">
            <input class="search-box" type="text" name="search" placeholder="キーワードを入力">
            <input class="search-btn" type="submit" value="検索">
          </form>
        </div>
        <!--header-search-->
        <div class="header-cart-btn">
          <a href="cart.php" class="header-box-anchor-cart">
            <img src="img/cart.png" alt="">
            <p class="header-text">カート</p>
          </a>
        </div>
        <!--header-cart-btn-->
        <div class="header-mypage-btn">
          <a href="mypage.php" class="header-box-anchor-user">
            <img src="img/mypage.png" alt="">
            <p class="header-text">Myページ</p>
          </a>
        </div>
        <!--header-mypage-btn-->
        <?php if (isset($_SESSION['login_id'])) : ?>
          <button class="header-log-out" onclick="location.href='logout.php'">ログアウト</button>
        <?php else : ?>
          <button class="header-new-member" onclick="location.href='user_entry.php'">新規会員登録</button>
          <button class="header-log-in" onclick="location.href='login.php'">ログイン</button>
        <?php endif; ?>
      </div>
    </div>
    <!--wrapper-->
  </header>
  <!-- ヘッダー　ここまで -->