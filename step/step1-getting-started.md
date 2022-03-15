# 기본 세팅

##### Table Of Contents
- [git](#git)
- [xampp](#xampp)

## Git
Git이 뭔지랑 설치법은 구글에 치면 나오니 생략한다. <br />
추가로 [github cli](https://cli.github.com/)도 설치한다. <br /><br />

git, github cli를 설치했다면 먼저 기본적인 설정이 필요하다.

```bash
git config --global user.name "여기다가 이름"
git config --global user.email "여기다가 이메일"

gh auth login -w
```

위 설정을 완료했다면 기본적인 git, github 세팅은 완료됐다. <br />
이제 git은 사용 준비를 맞췄고, 사용은 xampp 설명 이후에 할 예정이다.

## xampp
xampp는 php 개발 환경을 제공해주는 프로그램으로 xampp에서 제공하는 mysql database, apach web server로 기능대회에서 웹앱을 구성한다. <br />

사진에서 FileZilla FTP Server, Mercury Mail Server, Tomcat, Perl, Webalizer, Fake Sendmail은 사용하지 않으니 체크 해제한다.
![installer](https://www.notion.so/image/https%3A%2F%2Fs3-us-west-2.amazonaws.com%2Fsecure.notion-static.com%2F1b91bf49-1e43-4315-9732-4df01c40ab69%2FUntitled.png?table=block&id=d09a7674-2ba5-44fa-ab20-cabe1d3c2571&spaceId=f7040413-a730-44a9-ab18-368a23efcbb2&width=2000&userId=eb7bdd2e-40a3-460d-96cf-d0d10d47ee81&cache=v2)

<br />

계속 넘기다가 Leran more about Bitnami for XAMPP만 해제하고 게속 넘겨서 설치한다.
![bitnami-for-xampp](https://www.notion.so/image/https%3A%2F%2Fs3-us-west-2.amazonaws.com%2Fsecure.notion-static.com%2F10ebdb64-27b0-45e5-af6e-19256e88447a%2FUntitled.png?table=block&id=d2e18a11-3bbd-46cf-8814-4addad18188d&spaceId=f7040413-a730-44a9-ab18-368a23efcbb2&width=2000&userId=eb7bdd2e-40a3-460d-96cf-d0d10d47ee81&cache=v2)

<br />

xampp를 실행하면 아래처럼 panel이 뜰텐데 Explorer를 클릭하면 C:\xampp 폴더가 열리고 xampp가 설치된걸 확인할 수 있다. <br />
Apach, MySQL의 Start를 누르고 http://127.0.0.1에 접속해보자.
![xampp panel](https://www.notion.so/image/https%3A%2F%2Fs3-us-west-2.amazonaws.com%2Fsecure.notion-static.com%2F1f3965a2-4ed6-49fe-b5b3-bfbb1790e075%2FUntitled.png?table=block&id=e110541c-00de-48b5-a9f4-989b472f4a6b&spaceId=f7040413-a730-44a9-ab18-368a23efcbb2&width=2000&userId=eb7bdd2e-40a3-460d-96cf-d0d10d47ee81&cache=v2)

<br />

정상적으로 시작됐다면 아래처럼 화면이 표시된다.
![localhost](https://www.notion.so/image/https%3A%2F%2Fs3-us-west-2.amazonaws.com%2Fsecure.notion-static.com%2F8bdb2957-136e-4c8b-9f04-09a4847f80be%2FUntitled.png?table=block&id=bb2757e6-9801-4080-b1f1-2dd6cf1e058b&spaceId=f7040413-a730-44a9-ab18-368a23efcbb2&width=2000&userId=eb7bdd2e-40a3-460d-96cf-d0d10d47ee81&cache=v2)

<br />

xampp는 기본적으로 C:\xampp\htdocs 폴더를 root로 해서 호스팅한다. root 폴더를 어디로 할지는 Apacth -> Config -> httpd.conf를 메모장으로 열어서 DocumentRoot를 찾으면(control+f) 아래 내용을 확인할 수 있는데, path를 변경하고 시작하면 변경된 path를 root로 서버가 실행된다.
```txt
DocumentRoot: "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs>
```
![Apatch-config-httpd.conf](https://www.notion.so/image/https%3A%2F%2Fs3-us-west-2.amazonaws.com%2Fsecure.notion-static.com%2F4785c079-7b0e-45a0-a408-d15bf3454d0b%2FUntitled.png?table=block&id=f03a0574-0695-4c65-a882-f4a325bd1e90&spaceId=f7040413-a730-44a9-ab18-368a23efcbb2&width=2000&userId=eb7bdd2e-40a3-460d-96cf-d0d10d47ee81&cache=v2)

<br />

이제 htdocs 폴더에 있던 파일들을 다 삭제하고 index.php를 생성하자. php 파일은 확장자는 php이지만 html처럼 사용할 수 있다. <br />
아래처럼 내용을 작성하고 http://127.0.0.1를 확인하자. "하이"가 잘 보이는걸 확인할 수 있다. <br />
web server는 기본적으로 index 파일에 접근하기 때문에 따로 /index.php를 입력하지 않아도 index.php를 표시한다. <br />
index.php 대신 index.html 파일을 만들고 접근해도 동일한 결과가 화면에 표시된다.
```html
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello world</title>
</head>
<body>
  <h1>하이</h1>
</body>
</html>
```

대충 xampp 맛을 봤으니 php-tutotiral repository를 htdocs에 clone 하자

```bash
cd /C/xampp/htdocs
git clone https://github.com/wsssssssssss/php-tutorial.git
```

위 코드를 따라 쳤다면 htdocs에 php-tutorial 폴더가 생성된걸 확인할 수 있다. 해당 clone 폴더는 앞으로 진행할 글들에서 사용할 예정이다.<br />

이 글에서는 git, github cli, xampp를 설치하고 아주 약간씩 알아보고 사용해봤다. 다음 글에서는 본격적으로 php, web server에 대해서 알아보자.