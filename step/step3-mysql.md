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
예제는 ex/mysql을 사용한다. ex/mysql을 확인해보면 template(header, footer), index, login, register 페이지가 있는걸 볼 수 있다. <br />
우리가 할 작업은 아래와 같다.
1. post 액션을 처리하는 파일을 생성한다.
2. mysql db에 접근하는 구현체를 만든다.
3. 세션을 세팅하고, 구현체를 사용해 회원가입, 로그인, 로그아웃 기능을 구현한다.

### post 액션을 처리하는 파일을 생성하기
login.php, register.php 파일을 확인해보면 action이 "/user/login.php", "/user/register.php"가 들어 있는걸 볼 수 있다.  <br />
액션에 맞게 user 폴더를 만들고 login.php, register.php 파일을 생성하자.