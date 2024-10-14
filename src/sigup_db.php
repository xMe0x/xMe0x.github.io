<?php
session_start();
require_once 'config/conn.php';

if(isset($_POST['signup'])){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $con_password = $_POST['con_password'];
    $urole = 'user';

    if($password != $con_password){
        $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        header("location: index.php");
    } else {
        try {
            // ตรวจสอบอีเมลและชื่อผู้ใช้
            $check_user = $conn->prepare("SELECT email, username FROM users WHERE email = :email OR username = :username");
            $check_user->bindParam(":email", $email);
            $check_user->bindParam(":username", $username);
            $check_user->execute();
            $row = $check_user->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                if ($row['email'] == $email) {
                    $_SESSION['warning'] = 'มีอีเมลนี้อยู่ในระบบอยู่แล้ว';
                } elseif ($row['username'] == $username) {
                    $_SESSION['warning'] = 'มีชื่อผู้ใช้นี้อยู่ในระบบอยู่แล้ว';
                }
                header("location:index.php");
            } else if (!isset($_SESSION['error'])) {
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users(firstname, lastname, username, email, password, urole) VALUES(:firstname, :lastname, :username, :email, :password, :urole)");
                $stmt->bindParam(":firstname", $firstname);
                $stmt->bindParam(":lastname", $lastname);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":password", $passwordHash);
                $stmt->bindParam(":urole", $urole);
                $stmt->execute();
                $_SESSION['success'] = "สมัครสมาชิกเสร็จเรียบร้อยแล้ว";
                header("location:index.php");
            } else {
                $_SESSION['error'] = "ระบบมีข้อผิดพลาดกรุณาแจ้งแอดมิน";
                header("location:index.php");
            }

        } catch(PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header("location:index.php");
        }
    }
}
?>
