<?php

session_start();
$pagetitle = 'トップページ';
include('header.php');

?>

<div class="line nav">
    <nav class="main-nav wrapper">
        <li><a href="categoryman.php">男性コミック</a></li>
        <li><a href="categorywoman.php">女性コミック</a></li>
        <li><a href="categoryboy.php">少年コミック</a></li>
        <li><a href="categorygirl.php">少女コミック</a></li>
        <li><a href="newitem.php">新着順</a></li>
        <li><a href="ranking.php">ランキング</a></li>
    </nav>
</div><!--line nav-->
<div class="line top">
    <div class="wrapper">
        <p>新刊続々入荷中！！</p>
    </div><!--wrapper-->
</div><!--line top-->

<main class="wrapper">
    <div class="main-text">
        <h2>hontoについて</h2>
        <p>コミックの通販ならhontoにお任せ！コミックに特価した通販サイトです。</p>
        <div class="main-img">
            <img src="img/postage.png" alt="送料無料画像">
        </div>
    </div>
    <div class="bookshelf">
        <?php
        try {
            $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
            $user = "root";
            $password = "";

            $dbh = new PDO($dsn, $user, $password);
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            $sql = "SELECT * FROM books WHERE flg=0 ORDER BY publish_date DESC LIMIT 7 ";
            $stmt = $dbh->prepare($sql);

            $stmt->execute();
        } catch (PDOException $e) {
            exit('エラー：' . $e->getMessage);
        }
        ?>
        <div>
            <div class="bookshelf-item">
                <p>新刊 続々追加！</p>
                <a href="newitem.php">一覧を見る</a>
                <?php
                while (true) :
                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($rec === false) :
                        break;
                    endif;
                    $isbn = $rec['isbn'];
                    if (empty($rec['img'])) :
                        $img = '';
                    else :
                        $img = '<img src="img/' . $rec['img'] . '">';
                    endif; ?>
                    <a href="search.php?code=<?= $isbn; ?>">
                        <?= $img; ?>
                    </a>
                <?php endwhile; ?>
            </div>
            <div class="bookshelf-parts1"></div>
        </div>

        <?php
        try {
            $sql = "SELECT * FROM books WHERE flg=0 ORDER BY publish_date DESC LIMIT 7,9 ";
            $stmt = $dbh->prepare($sql);

            $stmt->execute();
        } catch (PDOException $e) {
            exit('エラー：' . $e->getMessage);
        }
        ?>
        <div>
            <div class="bookshelf-item">
                <?php
                while (true) :
                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($rec === false) :
                        break;
                    endif;
                    $isbn = $rec['isbn'];
                    if (empty($rec['img'])) :
                        $img = '';
                    else :
                        $img = '<img src="img/' . $rec['img'] . '">';
                    endif; ?>
                    <a href="search.php?code=<?= $isbn; ?>">
                        <?= $img; ?>
                    </a>
                <?php endwhile; ?>
            </div>
            <div class="bookshelf-parts2"></div>
        </div>
        <?php
        try {
            $sql = "SELECT * FROM books WHERE flg=0 ORDER BY publish_date DESC LIMIT 16,7 ";
            $stmt = $dbh->prepare($sql);

            $stmt->execute();
        } catch (PDOException $e) {
            exit('エラー：' . $e->getMessage);
        }
        ?>
        <div>
            <div class="bookshelf-item">
                <?php
                while (true) :
                    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($rec === false) :
                        break;
                    endif;
                    $isbn = $rec['isbn'];
                    if (empty($rec['img'])) :
                        $img = '';
                    else :
                        $img = '<img src="img/' . $rec['img'] . '">';
                    endif; ?>
                    <a href="search.php?code=<?= $isbn; ?>">
                        <?= $img; ?>
                    </a>
                <?php endwhile; ?>
            </div>
            <div class="bookshelf-parts3"></div>
        </div>
    </div>
    <!--bookshelf-->

    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=2 AND flg=0 ORDER BY publish_date DESC LIMIT 10 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>【新着】男性コミック</p>
        <a href="newcategoryman.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>
    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=4 AND flg=0 ORDER BY publish_date DESC LIMIT 10 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>【新着】女性コミック</p>
        <a href="newcategorywoman.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>

    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=1 AND flg=0 ORDER BY publish_date DESC LIMIT 10 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>【新着】少年コミック</p>
        <a href="newcategoryboy.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>
    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=3 AND flg=0 ORDER BY publish_date DESC LIMIT 10 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>【新着】少女コミック</p>
        <a href="newcategorygirl.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>
    <?php
    try {
        $dsn = "mysql:host=localhost;dbname=manga;charset=utf8";
        $user = "root";
        $password = "";

        $db = new PDO($dsn, $user, $password);

        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = 'SELECT books.isbn, title, price, stock, publish_date, author, publish, img, SUM(quantity) FROM books 
    JOIN purdetails ON books.isbn = purdetails.isbn WHERE books.flg=0 group by books.isbn ORDER BY SUM(quantity) DESC LIMIT 10';
        $stmt = $db->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー' . $e->getMessage());
    } ?>

    <div class="category-title">
        <p>ランキング</p>
        <a href="ranking.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>

    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=2 AND flg=0 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>男性コミック</p>
        <a href="categoryman.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>
    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=4 AND flg=0 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>女性コミック</p>
        <a href="categorywoman.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>

    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=1 AND flg=0 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>少年コミック</p>
        <a href="categoryboy.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <div class="out-stock-btn">
                            <input class="out-stock-btn" type="submit" value="在庫切れ">
                        </div>
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>
    <?php
    try {
        $sql = "SELECT * FROM books WHERE category_id=3 AND flg=0 ";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();
    } catch (PDOException $e) {
        exit('エラー：' . $e->getMessage);
    }
    ?>
    <div class="category-title">
        <p>少女コミック</p>
        <a href="categorygirl.php">一覧を見る</a>
    </div>
    <div class="category-wrapper">
        <span class="arrow left"></span>
        <div class="items">
            <?php
            while (true) :
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($rec === false) :
                    break;
                endif;
                $isbn = $rec['isbn'];
                if (empty($rec['img'])) :
                    $img = '';
                else :
                    $img = '<img src="img/' . $rec['img'] . '">';
                endif; ?>
                <a href="search.php?code=<?= $isbn; ?>">
                    <?= $img; ?>
                    <p><?= $rec['title']; ?></p>
                    <p><?= $rec['author']; ?></p>
                    <p>税込<?= $rec['price']; ?>円</p>
                    <?php
                    if ($rec['stock'] > 0) : ?>
                        <form action="cart_insert.php" method="post">
                            <input type="hidden" name="isbn" value="<?= $rec['isbn']; ?>">
                            <input type="hidden" name="title" value="<?= $rec['title']; ?>">
                            <input type="hidden" name="author" value="<?= $rec['author']; ?>">
                            <input type="hidden" name="publish" value="<?= $rec['publish']; ?>">
                            <input type="hidden" name="publish_date" value="<?= $rec['publish_date']; ?>">
                            <input type="hidden" name="count" value="1">
                            <input type="hidden" name="price" value="<?= $rec['price']; ?>">
                            <input type="hidden" name="img" value="<?= $rec['img']; ?>">
                            <input class="cart-btn" type="submit" value="カートに入れる">
                        </form>
                    <?php else : ?>
                        <input class="out-stock-btn" type="submit" value="在庫切れ">
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <span class="arrow right"></span>
    </div>
    <!-- meselect追加 -->
    <?php include('myselect.php'); ?>
    <!-- meselect終了 -->
</main>

<?php

include('footer.php');

?>