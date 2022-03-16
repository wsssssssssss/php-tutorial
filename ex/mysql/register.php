<?php require "./template/header.php" ?>

<p>회원가입 페이지 입니다.</p>
<form action="/user/register.php" method="post">
  <input type="text" name="id" placeholder="Input email">
  <input type="password" name="pw" placeholder="Input password">
  <input type="password" name="pw_confirm" placeholder="Input password again">
  <button type="submit">회원가입</button>
</form>

<?php require "./template/footer.php" ?>