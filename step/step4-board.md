# 게시판 앱 만들기
지금까지 배운걸 바탕으로 게시판 앱을 만들어 볼 것이다. 사이트맵은 아래와 같다.
```md
/ (index page)
  /page/register.php (회원가입 페이지)
  /page/login.php (로그인 페이지)
  /page/board.php (게시판 페이지)
  /page/detail.php (게시판 글 세부 페이지)

  /user/register.php (회원가입 기능)
  /user/login.php (로그인 기능)
  /user/logout.php (로그아웃 기능)

  /board/write.php (글 작성 기능)
  /board/comment.php (댓글 작성 기능)
```

위 사이트맵에서 예측할 수 있듯이 전체적인 기능은 아래와 같다.
1. Auth (로그인, 로그아웃)
2. Board (글 작성)
3. Comment (글에 댓글 작성)

먼저 전체적인 파일 구조는 아래와 같다.
<img width="275" alt="image" src="https://user-images.githubusercontent.com/32596517/158423805-4b0261a9-ff86-4205-8dda-3e64a5f2569d.png">
- board: board와 관련된 기능 파일들
- page: 실제 화면을 그려주는 UI 파일들
- src: 앱의 기본적인 소스코드들을 저장하는 폴더. 현재는 php file에 직접 접근(/page/register.php 처럼)하기 때문에 DB, lib만 존재한다.
- template: 페이지의 header, footer template 파일
- user: 유저의 auth 기능 파일들
- index.php: index 페이지 파일

구현의 순서는 아래와 같다.
1. DB.php 세팅
2. auth UI, 기능 구현 (auth 관련 DB 설계 및 페이지와 기능들을 구현한다.)
3. board UI, 기능 구현 (board 관련 DB 설계 및 페이지와 기능들을 구현한다.)
4. comment UI, 기능 구현 (comment 관련 DB 설계 및 UI와 기능들을 구현한다.)
5. index.php의 UI 구현 (index 페이지의 UI를 구현한다.)

## DocumentRoot 세팅
먼저 apache의 DocumentRoot를 ex/board로 변경한다.

## DB.php 세팅

먼저 MySQL에 board db를 추가한다.
(board db 추가 이미지)

dbname을 board로 하는 DB 구현체를 추가한다.
(DB.php 캡쳐)


## auth UI, 기능 구현



## board UI, 기능 구현



## comment UI, 기능 구현



## index.php UI 구현
