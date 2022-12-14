<?php
$pagetitle = 'お客様情報の入力';
include('header.php');

$sum_item = 0;
$sum_price = 0;

?>
<main class="wrapper">
    <p>お客様情報の入力</p>
    <form action="buy_check.php" method="post">
        <article>
            <table>
                <tr>
                    <th>郵便番号 必須</th>
                    <td><?= text($row['post']); ?></td>
                </tr>
                <tr>
                    <th>所在地(都道府県)</th>
                    <td><?= text($row['prefecture']); ?></td>
                </tr>
                <tr>
                    <th>所在地(市区町村／番地)</th>
                    <td><?= text($row['city']); ?></td>
                </tr>
                <tr>
                    <th>所在地(建物名)</th>
                    <td><?= text($row['o_address']); ?></td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td><?= text($row['phone']); ?></td>
                </tr>
            </table>
            <p>配送先変更の場合は<a href="loginedit.php">お客様情報変更</a>ページで登録の変更をお願いします。</p>
            <p><?= $message; ?></p>
            <table>
                <tr>
                    <th>お支払い方法を選択して下さい。</th>
                    <td>
                        <input type="radio" name="payment" value="クレジットカード">クレジットカード
                    </td>
                    <td>
                        <input type="radio" name="payment" value="コンビニ支払い">コンビニ支払い
                    </td>
                    <td>
                        <input type="radio" name="payment" value="電子マネー">電子マネー
                    </td>
                    <td>
                        <input type="radio" name="payment" value="代引き">代引き
                    </td>
                </tr>
            </table>
        </article>
        <aside>
            <?php foreach ($_SESSION['cart'] as $isbn => $value) : ?>
                <?php $sum_item += intval(text($value['count'])); ?>
                <?php $sum_price += intval(text($value['count'])) * intval($value['price']); ?>
            <?php endforeach; ?>
            <table>
                <tr>
                    <th>数量合計</th>
                    <td><?= $sum_item; ?> 冊</td>
                </tr>
                <tr>
                    <th>お支払い合計</th>
                    <td><?= number_format($sum_price); ?> 円</td>
                </tr>
            </table>
        </aside>
        <input type="submit" value="ご注文内容を確認">
    </form>
</main>