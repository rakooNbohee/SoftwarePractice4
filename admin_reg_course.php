<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title></title>
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
  <style>
    table {
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid black;
    }
  </style>
</head>
<body>
  <div id="header">
    <span id="header_title">Welcome to sugang sinchung</span>
    <span id="header_line">
     <?php
       session_start();
       if(!isset($_SESSION['result'])){
         header('Location: ./login.html');
       }

       echo $_SESSION['result']['name'];
     ?>
      님 안녕하세요!&nbsp;&nbsp;
      <form style="display:inline;" method="post" action="logout.php">
        <input type="submit" value="로그아웃">
      </form>
  </div>
  <div id="middle">
    <div id="nav">
      <ul>
        <li><a href="admin_reg_student.php">학생 등록</a></li>
        <li><a href="admin_reg_course.php">수업 등록</a></li>
        <li><a href="admin_course_list.php">수업 목록</a></li>
      </ul>
    </div>
    <div id="content">
      <h3>수업 등록</h3>
      <form action="./php/admin_reg_course.php" method="post">
        교과목명: <input type="text" name="name"><br>
        교강사명: <input type="text" name="prof"><br>
        수강인원: <input type="number" name="limit"><br>
        수업 요일 및 시간:
        <select name="day">
          <option value="월요일">월</option>
          <option value="화요일">화</option>
          <option value="수요일">수</option>
          <option value="목요일">목</option>
          <option value="금요일">금</option>
        </select>
        <select name="time">
          <option value="1교시">1교시</option>
          <option value="2교시">2교시</option>
          <option value="3교시">3교시</option>
          <option value="4교시">4교시</option>
          <option value="5교시">5교시</option>
          <option value="6교시">6교시</option>
        </select><br>

        학점:
        <input type="radio" name="credit" value="1">1학점
        <input type="radio" name="credit" value="2">2학점
        <input type="radio" name="credit" value="3">3학점<br>
        대상학년:
        <input type="radio" name="grade" value="1">1학년
        <input type="radio" name="grade" value="2">2학년
        <input type="radio" name="grade" value="3">3학년
        <input type="radio" name="grade" value="4">4학년<br>
        강의실:
        <select name="room">
          <option value="A">room A</option>
          <option value="B">room B</option>
          <option value="C">room C</option>
          <option value="D">room D</option>
        </select><br>
        <input type="submit" value="등록">
      </form>
    </div>
  </div>
  <div id="footer">
    <span id="footer_line">SWEX4 Final Project LeeBoHee & JeonSuBin</span>
  </div>
</body>
</html>
