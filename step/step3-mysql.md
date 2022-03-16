# MySQL
이 글은 php, xampp에 대한 기본적인 지식을 가지고 있다는 가정하에 작성되었습니다. <br />

이제 mysql을 알아보고 실제 사용하는 앱을 만들어 보자. <br />

먼저 보통 xampp를 통해 mysql에 접근하려면 phpmyadmin을 사용한다. phpmyadmin은 mysql 관리를 웹에서 할 수 있게 해주는 기능이라 생각하면 된다. <br />
xampp에서 mysql, apache를 시작하고 http://127.0.0.1/phpmyadmin을 접근해보자. 아래처럼 사이트가 표시되는걸 볼 수 있다.
<img src="">

이제 실제 DB를 만들어보자 만드는건 아래 동영상을 그대로 따라하면 된다. DB의 이름은 일단 "firstdb"로 하자.
(video)

firstdb를 만들었다면 해당 db에 table을 추가해야 한다. 아래 동영상을 참고해서 "user" 테이블을 만든다.
(video)
위 비디오를 보면 알 수 있듯이 idx, email, pw를 필드로 하는 user table을 생성한다.

- A_I를 체크하는걸 볼 수 있고 이건 autoincrement를 뜻하는데 해당 값은 데이터가 추가될때마다 자동으로 ++된다는 뜻이다
- string 데이터의 종류로 varchar, text 이렇게 두개를 보통 사용하는데 기능대회에서는 text를 무조건 사용한다. 둘 사이의 차이는 길이 지정, 저장 속도등이 있는데 text가 사용이 편리하기 때문에 text를 사용한다.
- 데이터정렬방식은 해당 utf8_머시기 utf8_저시기 이렇게 여러 종류가 있는데 쉽게 넘어가자면 지원하는 글자의 종류라 보면 되고, 기능대회에서는 utf8mb4_unicode_ci만 사용한다.

위 과정을 거쳤다면 "user" table이 생성된걸 확인할 수 있다.
(capture image)

## MySQL Auth App
이제 실제로 user table을 활용해서 php로 login 기능이 있는 앱을 만들고 실제로 db에 접근해보자. <br />
예제는 ex/mysql을 사용한다. 먼저 xampp의 root dir을 ex/mysql로 변경해야 하는데, step1 문서의 httpd.conf 관련 세팅 글을 참고해서 ex/mysql 폴더로 변경한다. 변경하고 앱을 실행했을때 페이지가 정상적으로 표시되지 않으면 설정이 잘못된것이니 다시 확인해본다. <br />
ex/mysql을 확인해보면 template(header, footer), index, login, register 페이지가 있는걸 볼 수 있다. <br />
우리가 할 작업은 아래와 같다.
1. post 액션을 처리하는 파일을 생성한다.
2. mysql db에 접근하는 구현체를 만든다.
3. 세션을 세팅하고, 구현체를 사용해 회원가입, 로그인, 로그아웃 기능을 구현한다.

### post 액션을 처리하는 파일을 생성하기
login.php, register.php 파일을 확인해보면 action이 "/user/login.php", "/user/register.php"가 들어 있는걸 볼 수 있다.  <br />
액션에 맞게 user 폴더를 만들고 login.php, register.php 파일을 생성하자.
| before | after |
| ------- | ------- |
| <img width="304" alt="image" src="https://user-images.githubusercontent.com/32596517/158408899-95afc584-3a21-4ad1-9df3-97207616b2bc.png"> | <img width="304" alt="image" src="https://user-images.githubusercontent.com/32596517/158409216-75937b35-a674-491d-93cb-a14cef6b860d.png"> |
| ------- | ------- |

먼저 register.php를 작업해보자. form의 method가 post이므로 form 전송 값은 $_POST로 접근한다. <br />
아래처럼 작업하고 /register.php에서 form 제출 시 id / pw가 화면에 표시되는걸 볼 수 있다.
```php
# register.php
<?php

echo "$_POST['id'] / $_POST['pw'] / $_POST['pw_confirm']";
```
(register ex img)

위 예시로 id, password, password confirm에 접근할 수 있는걸 알 수 있다. login에서도 동일하게 id, pw를 접근하는 코드를 작성하자.
```php
# login.php
<?php

echo "$_POST['id'] / $_POST['pw']";
```
(login ex img)

이제 우리는 유저가 제출한 데이터에 접근하고 제어할 수 있다. 해당 데이터를 DB에 저장해보자.

### MySQL DB 접근 구현체 만들기
먼저 ex/mysql에 DB.php 파일을 추가한다. 아래 코드와 주석을 살펴보면서 이해해보자. 아래 코드는 db에 대한 기본적인 지식이 있다는 가정하에 주석이 달려있다.
```php
# DB.php
<?php

class DB { // 실제 데이터베이스에 접근하는 class이다.
  static $db = null; // pdo 객체를 접근하는 static variable
  static function get() { // $db getter 함수이다. 만약 $db가 없다면 $db로 새로운 conenct를 지정한다.
    if (!self::$db) { // $db가 없을 경우 즉, 첫 접근일 경우
      $option = [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]; // 해당 부분은 일단 무시해도 된다. // 아주 간단하게 알아보면 ATTR_DEFAULT_FETCH_MODE은 db에서 데이터를 fetch(가져오기)할때 어떻게 가져올지를, ATTR_ERRMODE는 에러가 발생했을때 어떻게 대응할지를 세팅하는 거다.

      /*
        실제 mysql와 연결하는 pdf 객체이다. 파라미터를 살펴보면
          1. db 연결에 대한 정보를 가지고 있다. 기능대회 기준으로 dbname 부분만 db의 이름에 따라 변경되고 나머지는 고정으로 외우면 된다.
          2. db에 접근할때 사용하는 id로 "username" 고정이다.
          3. password로 빈 스트링 고정이다.
          4. 접근에 대한 option으로 이 부분도 그냥 기능대회 기준으로 고정이다.
      */
      self::$db = new \PDO("mysql:host=localhost;dbname=firstdb;charset=utf8mb4", "root", "", $option);
    }

    return self::$db; // $db getter 함수이니 $db를 return한다.
  }
}

// ex) query("SELECT * FROM user where idx = ? AND id = ?", [3, "email@naver.com"]);
// 위 ex에서 sql문에 ?가 있는걸 볼 수 있는데 해당 데이터는 $data의 값이 순서대로 들어간다. 실제 적용이 된다면 아래와 동일하다 생각하면 된다.
// SELECT * FROM user where idx = 3 AND id = email@naver.com
function query($sql, $data = []) { // db에 query를 날리는 함수이다. query는 db 정보를 요청(select), 추가(insert), 수정(update), 삭제(delete)를 할때 사용한다.
  $q = DB::get()->prepare($sql); // DB::get()은 위 DB class에서 get 메소드를 호출한다는 뜻으로 DB class의 $db를 가져온다. "->preapare"는 $db의 prepare 메소드를 호출한다는 뜻이다. // prepare 메소드는 sql query 문을 db에서 실행하기 전에 준비(prepare)한다.

  try {
    $q->execute($data); // 준비(prepare)한 데이터를 실행(execute)한다. // 만약 해당 실행에서 오류(db가 올바르지 않다거나 sql 문이 올바르지 않다거나)가 발생하면 try catch에 따라 catch문으로 이동한다.

    return $q; // DB에 execute가 완료됐다면 해당 데이터를 return한다.
  } catch() {
    return false; // db에 query를 날렸을떄 에러가 나면 return false를 한다.
  }
}

function fetch($sql, $data = []) { // fetch는 query의 결과에서 하나의 row를 가져온다.
  $q = query($sql, $data); // query 실행

  return $q ? $q->fetch() : $q; // query 실행 결과가 false가 아닐때만 fetch 함수를 실행해 row 하나를 가져옴
}

function fetchAll($sql, $data = []) { // fetchAll은 query의 결과에서 모든 row들을 가져온다.
  $q = query($sql, $data); // query 실해

  return $q ? $q->fetchAll() : $q; // query 실행 결과가 false가 아닐때만 fetchAll을 실행해 모든 row를 가져옴
}

function find($table, $id) { // 특정 table의 특정 id값 데이터를 가져오고 싶을때 사용하는 함수
  return fetch("SELECT * FROM `$table` WHERE id = ?", [$id]); // table의 id에 맞는 데이터를 하나 가져온다.
}

function lastInsertId() { // db에 마지막으로 insert한 데이터의 id를 가져오는 함수이다.
  return DB::get()->lastInsertId(); 
}

```

위 코드를 살펴봤을때 이미 데이터베이스에 대한 지식이 있다면 이해하기 쉬울 것이다. 이해하기 어려워도 일단 위 코드를 사용해서 DB에 접근할 수 있다는걸 이해하기만 하면 된다.

### 세션 세팅, auth 기능 구현
DB 구현체를 만들었으니 이제 DB에 데이터를 저장할 수 있다. 회원가입 데이터를 실제로 user table에 저장해보자.
```php
# user/register.php
<?php

require "../DB.php"; // DB 관련 함수들 (query, fetch, fetchAll, ...)을 가져옴

extract($_POST); // 특정 배열, 객체 내부의 값들을 변수로 가져오는 함수로 $_POST에 id, pw값이 있을 경우 해당 값들은 $id, $pw로 저장된다. 기능대회 기준으로는 사용해도 상관 없지만 실제 프로덕트에서는 사용하면 위험하다.

if ($pw !== $pw_confirm) { // 비밀번호가 비밀번호 확인과 다를 경우
  echo "<script>alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');history.back();</script>"; // alert 표시 후 이전 reigster 페이지로 돌아감

  exit; // 코드의 실행을 여기서 종료한다는 뜻
}

$rs = query("INSERT into user set email = ?, pw = ?", [$id, $pw]); # user table에 insert문을 날려서 db에 데이터를 추가함

if ($rs) {
  echo "<script>alert('회원가입 성공!');location.replace('/login.php');</script>"; // alert 표시 후 login 페이지로 이동함

  exit; // 코드의 실행을 여기서 종료한다는 뜻
}

# $rs가 false여서 exit되지 않았을 경우 query문 에서 뭔가 에러가 있었다는 뜻
```

위 예제대로 작성 후에 register 페이지에서 가입을 해보면 아래 사항들을 확인할 수 있다.
1. 비밀번호, 비밀번호 확인이 다를 경우 회원가입이 차단된다.
2. 회원가입 완료시 login 페이지로 이동한다.

이제 phpmyadmin에서 user table로 접근해보면 실제로 입력한 데이터들이 쌓이는걸 볼 수 있다.
(phpmyadmin user 사진)

이제 DB에 저장된 유저의 정보와 session을 이용해서 login 기능을 구현해보자
```php
# index.php

<?php
  session_start(); // session을 열어준다.
?>
<?php require "./template/header.php" ?>
안녕하세요 메인 페이지입니다.
<?= $_SESSION['user'] ? "id = $_SESSION['user']['id']" : "" =>
<?php require "./template/footer.php" ?>


# login.php
<?php
  session_start(); // session을 열어준다.

  if ($_SESSION['user']) {
    ?>
      <script>
        location.replace("/"); // 로그인된 유저는 /login.php에 접근 못하고 /로 redirect된다.
      </script>
    <?php 
  }
?>

... (기존 login.php 코드)


# register.php
<?php
  session_start(); // session을 열어준다.

  if ($_SESSION['user']) {
    ?>
      <script>
        location.replace("/"); // 로그인된 유저는 /register.php에 접근 못하고 /로 redirect된다.
      </script>
    <?php 
  }
?>

... (기존 register.php 코드)


# template/header.php
... (기존 template/header.php 코드)
<?php if($_SESSION['user']): // login된 유저일 경우 logout 메뉴를 보여줌 ?>
  <li><a href="/logout.php">Logout</a></li>
<?php else: // 로그인 안된 유저는 login, register 메뉴를 보여줌 ?>
<li><a href="/login.php">Login</a></li>
<li><a href="/register.php">Register</a></li>
<?php endif; >


#user/login.php
<?php
  require "../DB.php";

  session_start(); // session을 열어준다.

  extract($_POST);

  $row = fetch("SELECT * FROM user where id = ? AND pw = ?", [$id, $pw]);

  if ($row) { // id, pw에 맞는 데이터가 db에 존재 할 경우
    $_SESSION['user'] = $row; // session 데이터로 유저의 정보를 저장한다.

    // alert 표시 후 메인 페이지로 이동한다.
    ?>
      <script>alert('로그인 성공!');location.replace('/');</script>
    <?php 

    exit;

  } else { // alert 표시 후 메인 페이지로 이동한다.
    ?>
      <script>alert('아이디 혹은 비밀번호가 올바르지 않습니다.');history.back();</script>
    <?php
  }


# logout.php
<?php 
session_start(); // session을 열어준다.

if (!$_SESSION['user']) { // 만약 로그인된 유저가 아닌 경우
  ?>
    <script>
      location.replace("/"); // index 페이지로 redirect 한다.
    </script>
  <?php
}

unset($_SESSION['user']); // user 데이터를 제거한다.

?>

<script>
  alert("로그아웃 성공");
  location.replace("/"); // index 페이지로 redirect 한다.
</script>

```

위 예제대로 작업을 했다면 아래 사항들을 확인할 수 있다.
1. 회원가입된 유저의 데이터를 로그인 페이지에서 입력 후 제출했을 경우 로그인이 정상적으로 된다.
2. index 페이지에서 로그인한 id 값을 확인할 수 있다.
2. 로그인된 유저는 header 메뉴가 변경되는걸 확인할 수 있고, /login.php, /register.php를 접근해도 페이지가 보이지 않고 redirect 된다.
3. 로그아웃 메뉴 클릭시 정상적으로 로그아웃 된다.
4. 로그인 안한 유저는 /logout.php를 접근해도 따로 액션 없이 index 페이지로 redirect 된다.

이 글에서는 실제 db를 생성해보고, 접근해보고, 방금 예제로 로그인 기능을 구현해보았다. 다음 글에서는 지금까지 배운걸 사용해서 게시판을 만들어 보자.