<!-- フッター -->
<a href="#" id="page-top"><i class="return"></i>トップへ戻る</a>
<footer class="footer">
    <div class="line bottom">
        <div class="wrapper">
            <div class="footertop">
                <nav class="footer">
                    <?php
                    if (!isset($_SESSION['login_id'])) : ?>
                        <li><a href="entry.php" class="">会員登録</a></li>
                    <?php endif; ?>
                    <li><a href="cart.php" class="">カート</a></li>
                    <li><a href="contact.php" class="a">お問い合わせ</a></li>
                </nav>
            </div>
        </div>
        <div class="footerbottom">
            Copyright &copy; B team Co., Ltd.
        </div>
    </div>
    <!-- フッターここまで -->
    </div>
    <script>
        document.querySelectorAll('.left').forEach(elm => {
            elm.onclick = function() {
                let div = this.parentNode.querySelector('.category-wrapper .items');
                div.scrollLeft -= (div.clientWidth / 2);
            };
        });
        document.querySelectorAll('.right').forEach(elm => {
            elm.onclick = function() {
                let div = this.parentNode.querySelector('.category-wrapper .items');
                div.scrollLeft += (div.clientWidth / 2);
            };
        });
    </script>
    </body>

    </html>