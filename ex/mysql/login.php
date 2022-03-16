<?php require "./template/header.php" ?>

<p>로그인 페이지 입니다.</p>
<form action="/user/login.php" method="post">
  <input type="text" name="id" placeholder="Input email">
  <input type="password" name="pw" placeholder="Input password">
  <button type="submit">로그인</button>
</form>

<?php require "./template/footer.php" ?>