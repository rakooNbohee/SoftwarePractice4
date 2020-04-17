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
  <script>
    function Delete(url){
      if(confirm("폐강하시겠습니까?")){
        location.href=url;
      }
    }
    function Check(){
      var radio=document.search.category;
      var word=document.search.text;
      var checked=false;
 
      if(radio[0].checked==true) checked=true;
      if(radio[1].checked==true) checked=true;
      
      if(checked && word.value==""){
        alert("검색어를 입력하세요");
        word.focus();
        return false;
      }
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
        <li><a href="admin_reg_student.php">학생 등록</a></li>
        <li><a href="admin_reg_course.php">수업 등록</a></li>
        <li><a href="admin_course_list.php">수업 목록</a></li>
      </ul>
    </div>
    <div id="content">
      <h3>수업 목록</h3>
      <form action="./php/admin_course_search.php" method="post" name="search" onsubmit="return Check()">
        <input type="radio" name="category" value="course_name" ondblclick="this.checked=false">교과목명
        <input type="radio" name="category" value="inst_name" ondblclick="this.checked=false">교강사명
        <select name="credit">
          <option value="">---</option>
          <option value="1">1학점</option>
          <option value="2">2학점</option>
          <option value="3">3학점</option>
        </select>
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
        <input type="text" name="text">
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
          <th>교과목명</th> <th>교강사명</th> <th>인원<br>신청/제한</th> <th>학점</th> <th>대상학년</th> <th>수업일시</th> <th>강의실</th> <th>신청상태</th> <th></th>
        </tr>
        <?php
          while($course = mysqli_fetch_array($result)){
            echo "<tr>
              <td>$course[name]</td>
              <td>$course[prof]</td>
              <td>$course[register]"?>/<?php echo "$course[maximum]</td>
              <td>$course[credit]</td>
              <td>$course[grade]학년</td>
              <td>$course[day] $course[time]</td>
              <td>room $course[room]</td>
              <td>$course[status]</td>
              <td><a class='href' href='#' onClick=Delete('./php/admin_delete.php?cid=$course[cid]')>삭제</a><br><a class='href' href='./php/admin_edit.php?cid=$course[cid]')>수정</a></td>
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
