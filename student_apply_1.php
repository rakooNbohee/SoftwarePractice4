<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title></title>
  <script>
    function Register(url){
      location.href=url;
    }
    function Wish(url){
      location.href=url;
    }
  </script>
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
    </span>
  </div>
  <div id="middle">
    <div id="nav">
      <ul>
        <li><a href="./student_apply_1.php">수강신청</a></li>
        <li><a href="./student_mypage.php">마이페이지</a></li>
      </ul>
    </div>
    <div id="content">
      <h3>수강신청</h3>
      <a class="href" href="#">수업 목록</a>
      <a class="href" href="./student_apply_2.php">위시 리스트</a>

      <form action="./php/student_course_search.php" method="post">
        교과목명<input type="text" name="course_name">
        <select name="grade">
          <option value="">---</option>
          <option value="1">1학년</option>
          <option value="2">2학년</option>
          <option value="3">3학년</option>
          <option value="4">4학년</option>
        </select>
        <select name="status">
          <option value="">---</option>
          <option value="폐강">폐강</option>
          <option value="진행중">진행중</option>
          <option value="신청종료">신청종료</option>
        </select>
        <input type="submit" value="검색">
      </form>


      <?php
        error_reporting(-1); // reports all errors
        ini_set("display_errors", "1"); // shows all errors
        ini_set("log_errors", 1);
        ini_set("error_log", "/tmp/php-error.log");

        $s = mysqli_connect("localhost", "root", "root","sw4");
        mysqli_set_charset($s,"utf8");

        $query = "select * from class";
        $result = mysqli_query($s, $query);
      ?>
      <table>
        <tr>
          <th>수강신청</th> <th>위시추가</th>
          <th>교과목명</th> <th>교강사명</th> <th>인원<br>신청/제한</th> <th>수업일시</th> <th>학점</th> <th>대상학년</th> <th>강의실</th> <th>신청상태</th>
        </tr>
        <?php
          $temp = $_SESSION['result']['studentid'];

          while($course = mysqli_fetch_array($result)){
            echo "<tr>
              <td><a class='href' href='#' onClick=Register('./php/student_register.php?cid=$course[cid]&sid=$temp')>신청하기</a></td>
              <td><a class='href' href='#' onClick=Wish('./php/student_wish.php?cid=$course[cid]&sid=$temp')>위시추가</a></td>
              <td>$course[name]</td>
              <td>$course[prof]</td>
              <td>$course[register]" ?>/<?php echo "$course[maximum]</td>
              <td>$course[day] $course[time]</td>
              <td>$course[credit]</td>
              <td>$course[grade]학년</td>
              <td>room $course[room]</td>
              <td>$course[status]</td>
            </tr>";
          }
        ?>
      </table>
    </div>
  </div>
  <div id="footer">
    <span id="footer_line">SWEX4 Final Project LeeBoHee & JeonSuBin</span>
  </div>
</body>
</html>

