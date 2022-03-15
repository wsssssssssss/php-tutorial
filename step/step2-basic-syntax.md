# Apache Web Server
php 문법을 알아보기전에 apache web server를 간단하게 알아보자.<br />
기능대회는 기본적으로 xampp를 활요해서 apache web server + mysql database로 C모듈을 구축한다. <br />
Apache web server란 http 웹 서버 소프트웨어로 기타 이것저것 설명이 많지만 어차피 문제 풀때 자세히 알 필요 없으니 스킵하고 그냥 web server 돌릴때 소프트웨어 딱 그 정도만 알면 된다. <br />
MySQL Database도 그냥 데이터 저장하려고 쓰는 db 시스템 정도로 알고 있자. <br />
xampp는 apache, mysql을 제공해주는 툴이다.

# PHP Basic Syntax
php의 기본적인 문법, 내장 함수들을 소개한다.

## 기본 문법

기본적인 php의 문법을 알아보자. <br />
php는 <?php, ?>이 태그 사이의 코드들만 php 코드로 해석하고 그 외는 html로 해석한다. 아래 예시를 확인하면 이해가 쉽다. <br />
태그를 <?= ?> 형식으로도 사용할 수 있는데 <?php echo ?>와 동일하다 보면 된다.

```php
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <?php
    echo '<span>PHP로 화면 출력하기</span>';
  ?>
  <p>여기는 HTML 영역 <b><?= '여긴 php 영역' ?></b> 다시 html 영역.</p>
  <p>위 형식은 short echo라 하는데 <b><?php echo '이렇게 하는것과 같다' ?></b></p>
</body>
</html>
```

만약 파일에 php 코드만 존재한다면 따로 close tag를 추가하지 않아도 된다.
```php
<?php

function t() {
  return 'Hi';
}

echo t();

// close tag가 없어도 잘 동작함
```

## 분기
PHP 인터프리터가 닫는 태그(?>)와 마주치면 다른 여는 태그(<?php or <?=)와 마주칠때까지 전부 html로 출력한다.

```php
<?php if ($expression == true) { ?>
  <p>expression이 true일 경우 나는 표시된다!</p>
<?php } else { ?>
  <p>그 외의 모든 경우는 내가 표시된다!</p>
<?php } ?>

<?php foreach($arr as $v) { >
  나는 빡빡이다<?= $v ?>
<?php } >
```
위 예제에서 html 컨텐츠가 php tag 외부에 있지만, php의 if, foreach, switch case 등등의 문들이 적용 된다. <br />
많은 양의 컨텐츠를 출력할때는 echo or print를 사용하는 것 보단 위 예시처럼 php 태그를 닫고 컨텐츠를 출력하는게 효율적이다.

### if, for, switch, while, foreach
php의 if, for, switch, while은 다른 언어들과 형식이 동일하다.

```php
// if
if ($expression) {
  echo '1';
} else if ($expression == 0) { // else if를 띄어쓰든
  echo '0';
} elseif ($expression == -1) { // 붙이든 상관없음
  echo '-1';
} else {
  echo '-2';
}

// for
for ($i = 1; $i <= 10; $i++) {
    echo $i;
}

// while
$i = 1;
while ($i <= 10) {
    echo $i++;
}

// switch
switch ($i) {
  case 0:
    echo "i equals 0";
    break;
  case 1:
    echo "i equals 1";
    break;
  case 2:
    echo "i equals 2";
    break;
}
```

<br />

foreach는 js의 Array.prototype.foreach와 비슷한데 배열, 객체의 loop를 쉽게 하기 위해 만들어졌다.
```php
$arr = [1, 2, 3, 4];

foreach ($arr as $value) { // value만 필요할 경우 $target as $value 형식으로 가져오면 됨
    echo $value;
}

$a = array(
    "one" => 1,
    "two" => 2,
    "three" => 3,
    "seventeen" => 17
);

foreach ($a as $key => $value) { // key도 필요할 경우 $target as $key => $value 형식으로 가져오면 됨
    echo "$key, $value \n";
}
```

<br />

추가적으로 위 문법들 대신 colon을 사용할 수도 있는데 여는 중괄호(```{```) 대신 ```:```, 닫는 중괄호(```}```) 대신 ```end*;``` 형식을 사용한다.
```php
if ($expression):
  echo '1';
elseif ($expression == 0):
  echo '0';
else:
  echo '-1';
endif;

# 보통 for, switch, while은 잘 안사용해서 스킵
$arr = [1, 2, 3, 4];

foreach ($arr as $value):
    echo $value;
endforeach;
```
## 주석

주석은 //, /* */, #이렇게 3개를 사용한다.

```php
// 주석 1
/* 주석 2 */
# 주석 3
```

## require, include
php에서도 js의 import, export처럼 다른 파일을 불러와서 사용할 수 있다. 그걸 하는게 include, require, include_once, require_once이다. <br />
기본적으로 ```include "filepath"``` 형식으로 파일을 불러오고 filepath는 현재 파일 기준이다.
```php
/*
/
  a.php
  r.php
  폴더1
    r.php
    현재 파일
*/
// 위 주석처럼 폴더가 있다고 가정하고, 현재 파일은 폴더1에 존재한다.

include "/a.php"; // 절대경로로 가져옴. root 폴더에 있는 a.php 라는 뜻 (../a.php와 동일함)
include "./r.php"; // 상대경로로 가져옴. 현재 파일이 있는 폴더에 있는 r.php 라는 뜻 (폴더1/r.php를 가져옴)
include "../r.php"; // 상대경로로 가져옴. 현재 파일이 있는 폴더의 부모 폴더에 있는 r.php 라는 뜻 (/r.php를 가져옴)
```

파일을 include하면 include한 line을 기준으로 해당 파일의 변수들의 스코프를 상속받는다. 쉽게 말하자면 include한 파일을 그대로 복붙해서 가져오는거라고 생각하면 쉽다.
```php
# vars.php
<?php

$color = 'green';
$fruit = 'apple';

?>

# test.php
<?php

echo "A $color $fruit"; // A ($color, $fruit이 선언 안되어 있어서 출력되지 않음)

include 'vars.php'; // vars.php를 include함 
/*
복붙해서 가져온다 생각하면 아래 처럼 변수를 그냥 선언한 셈

$color = 'green';
$fruit = 'apple';
*/

echo "A $color $fruit"; // A green apple (vars.php에 $color, $fruit이 선언되어 있기 때문에 해당 값들이 출력됨)

?>
```

그렇다면 include, require, include_once, require_once는 무슨 차이일까?
- include: 위 설명과 동일하고 여러번 include 할 수 있다.
- include_once: include와 동일하지만 include를 한번만 할 수 있다. 이미 incldue_once로 한번 include를 했다면 다시 include해도 동작하지 않는다. 
- require: include와 동일하지만 파일이 존재하지 않을 경우 에러를 출력하고 앱이 정지됨. (include는 경고 메세지만 출력하고 앱이 정지되진 않음)
- require_once: include_once와 동일한 형식임. include만 require로 바꿔 생각하면 됨

보통 기능대회에서는 require만 사용한다. 어차피 한 파일을 여러번 require하는 경우도 없기 때문이다. (autoloader의 경우 예외적으로 require_once 이건 추후 mvc에서 설명) <br />
간단하게 require를 사용해서 헤더와 푸터, 컨텐츠를 분리해보자.
```php
# header.php
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div class="app">
    <header>Header</header>
    <main>

# footer.php
    </main>
    <footer>Footer</footer>
  </div>
</body>
</html>

# 위 파일을 보면 header, footer에 html template의 header 부분과 footer 부분을 나눈걸 볼 수 있다.

# index.php
<?php require "header.php" ?>
여기는 index 페이지 입니다.
<?php require "footer.php" ?>

# login.php
<?php require "header.php" ?>
여기는 login 페이지 입니다.
<?php require "footer.php" ?>

```
위 처럼 작업 후 127.0.0.1, 127.0.0.1/login.php 접근시 컨텐츠랑 같이 header, footer가 정상적으로 표시되는걸 볼 수 있다. <br />
위처럼 require 사용시 중복 코드의 제거 및 소스 코드의 분리가 가능하기 때문에 유용하게 사용할 수 있다. 앞으로도 자주 사용할 기능이니 친숙해지자. <br />

## constants

### $_SERVER
서버와 실행 환경의 값들을 가지고 있다. <br />
현재 접근한 header, url path, location, 서버 주소, 페이지 접근에 사용된 method(get, post, put, delete, ...) 등등 여러가지 값들이 존재한다. 주로 사용하는 값들만 알아보자

#### $_SERVER["REQUEST_URI"]
페이지 접근에 사용된 uri를 가져온다. querystring까지 포함되어 있으므로 주의한다. ("/user/1?tab=repository")

#### $_SERVER["REQUEST_METHOD]
페이지 접근에 사용된 method를 가져온다. ex) 'GET', 'HEAD', 'POST', 'PUT'

#### $_SERVER["DOCUMENT_ROOT]
서버의 root path를 가져온다. ex) C:/xampp/htdocs

### $_GET
querystring(url parameter)로 받아온 값들을 가지고 있다.
```php
# /?name=기능반

echo "안녕, $_GET['name']"; // 안녕, 기능반
```

### $_POST
post method로 보낸 값들을 가지고 있다.

```php
# form tag를 method="post"로 설정후 name 값을 전송했을 경우

echo "안녕, $_POST['name']"; // 안녕, {이름 입력값}
```

### $_FILES
post method로 전송한 파일들을 가지고 있다. (file 전송시 form의 enctype을 "multipart/form-data"로 세팅해야 정상적으로 보내진다.)
```php
# <form method="post" enctype="multipart/form-data"><input type="file" name="img" /></form>을 submit 했다고 가정

print_r($_FILES); // img에 file에 대한 정보가 존재하는걸 확인할 수 있다.
```

### $_SESSION
session에 저장해둔 값들을 가지고 있다.

```php
# session에 유저 정보 저장했다 가정했을때 아래처럼 login, logout 버튼을 toggle 할 수 있다.


<?php if($_SESSION['user']): ?>
  <button>로그아웃</button>
<?php else: >
  <button>로그인</button>
<?php endif; >
```

## Session
기능대회에서 로그인을 관리할때는 세션을 사용한다. 세션에 대해 알아보자 <br />
세션이란 웹 서버에 임시로 저장할 수 있는 저장공간이다. 임시 공간이기 때문에 브라우저를 껏다 키면 데이터가 사라진다. <br />

php에서 세션을 시작하려면 session_start라는 함수를 호출해야 한다.
```php
# index.php

session_start(); // 다른 코드들 보다 우선적으로 실행해준다.

// ...

```

세션에 값을 저장하는 방법은 간단하다. ```$_SESSION``` 상수에 직접 값을 세팅하면 된다. 아래는 로그인, 로그아웃의 예시이다.
```php
<?php

session_start();

function login($userInfo) { // login 함수
  $_SESSION['user'] = $userInfo; // $_SESSION['user']에 유저의 정보를 저장함
}

function logout() { // logout 함수
  unset($_SESSION['user']); // unset은 변수 제거 함수임 말 그대로 변수를 제거하는거여서 $_SESSION['user']를 넣으면 session의 user가 제거됨
}
```

---------

이 글에서는 php의 기본 문법, 상수, 세션에 대해서 얕게 알아봤다. 위 내용만 있어도 db없이 session+(indexedDB or client storage)를 활용해서 앱을 만들수 있다. 다음 글에서는 mysql을 알아보자 <br />