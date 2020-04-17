<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title></title>
  <script>
    function Cancel(url){
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
      <h3>신청 현황</h3>
      <?php
        error_reporting(-1); // reports all errors
        ini_set("display_errors", "1"); // shows all errors
        ini_set("log_errors", 1);
        ini_set("error_log", "/tmp/php-error.log");

        $s = mysqli_connect("localhost", "root", "root","sw4");
        mysqli_set_charset($s,"utf8");
        
        $sid = $_SESSION['result']['studentid'];

        $query0 = "select * from student where studentid='$sid'";
        $result0 = mysqli_query($s, $query0);
        $result00 = mysqli_fetch_array($result0);

        echo "<h5>* 최대 신청 가능 학점: $result00[maxcredit]</h5>";
        echo "<h5>* 현재 신청한 학점: $result00[curcredit]</h5>";

        $query = "select * from class, (select mycid from oklist where mysid='$sid') as T where T.mycid=class.cid;";
        $result = mysqli_query($s, $query);
      ?>
      <table>
        <tr>
          <th>신청취소</th>
          <th>교과목명</th> <th>교강사명</th> <th>인원<br>신청/제한</th> <th>수업일시</th> <th>학점</th> <th>대상학년</th> <th>강의실</th> <th>신청상태</th>
        </tr>
        <?php
          $temp = $_SESSION['result']['studentid'];

          while($course = mysqli_fetch_array($result)){
            echo "<tr>
              <td><a class='href' href='#' onClick=Cancel('./php/student_cancel.php?cid=$course[cid]&sid=$temp')>취소하기</a></td>
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

      <br><h3>시간표 출력</h3>
      <table width="600" cellpadding="5" cellspacing="2" align="center" style="table-layout:fixed; text-align: center;">
        <tr>
          <th></th> <th>월</th> <th>화</th> <th>수</th> <th>목</th> <th>금</th> 
        </tr>

        <?php
          $query2 = "select * from oklist, class where (mmysid = '$sid') and (mmycid = cid);";
          $result2 = mysqli_query($s, $query);
          
          $timetable_array = array_fill(0, 30, "");

          while($course2 = mysqli_fetch_array($result2)){
            $index = 0;

            if($course2['day'] == '월요일'){ $index = 0; }
            else if($course2['day'] == '화요일'){ $index = 1; }
            else if($course2['day'] == '수요일'){ $index = 2; }
            else if($course2['day'] == '목요일'){ $index = 3; }
            else{ $index = 4; }

            if($course2['time'] == '1교시'){ $index += 0; }
            else if($course2['time'] == '2교시'){ $index += 5; }
            else if($course2['time'] == '3교시'){ $index += 10; }
            else if($course2['time'] == '4교시'){ $index += 15; }
            else if($course2['time'] == '5교시'){ $index += 20; }            
            else{ $index += 25; }

            $timetable_array[$index] = $course2['name'];
          }

          $n = 0;
          $l = 1;

          echo "<tr><th>$l</th>";
          foreach($timetable_array as $item){
            echo "<td>$item</td>";
            $n += 1;
            if($n == 5){
              $n = 0;
              $l += 1;
              if($l == 7) { echo "</tr>"; }
              else { echo "</tr><tr><th>$l</th>"; }
            }
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

