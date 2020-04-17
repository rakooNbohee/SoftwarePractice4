<?php
    session_start();

    $s = mysqli_connect("localhost", "root", "root", "sw4");
    mysqli_set_charset($s, "utf8");

    $login_html = file_get_contents("http://13.209.89.231/login.html");

    # get inputs
    $auth_d = $_POST["authority"];
    $id_d = $_POST["id"];
    $pw_d = $_POST["pw"];

    # admin login
    if($auth_d == "admin"){
        $re = mysqli_query($s, "SELECT * FROM admin WHERE id='$id_d' and password='$pw_d'");
        $result = mysqli_fetch_array($re);

        if($result['id']){
            $_SESSION['result'] = $result;
            if(isset($_SESSION['result'])){
              header('Location: ./admin_course_list.php');
            }
        }
        else{
            echo "<script>alert('관리자 로그인 실패')</script>";
            echo "".$login_html;
        }
    }

    # student login
    else{
        $re = mysqli_query($s, "SELECT * FROM student WHERE id='$id_d' and password='$pw_d'");
        $result = mysqli_fetch_array($re);

        if($result['id']){
            $_SESSION['result'] = $result;
            if(isset($_SESSION['result'])){
                header('Location: ./student_apply_1.php');
            }
        }
        else{
            echo "<script>alert('학생 로그인 실패')</script>";
            echo "".$login_html;
        }
    }

    mysql_close($s);
?>
