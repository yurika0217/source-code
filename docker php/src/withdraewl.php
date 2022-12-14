  <?= include('header.php'); ?>
  <div class="mywrapper">

    <div class="content">

      <h1>退会画面</h1>
      <p>退会しますか？</p>
      <form action="withdraewlconfirmation.php" method="POST">
        <input type="hidden" name="is_delete" value="1">
        <input type="submit" value="退会する">
      </form>
      <p><a href="index.php">トップに戻る</a></p>
    </div>
  </div>
  <?= include('footer.php'); ?>