<?php
session_start();
require_once 'config/conn.php';

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอกชื่อผู้ใช้';
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
    } else {
        try {
            $check_data = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $check_data->bindParam(":username", $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if ($username == $row['username']) {
                    if (password_verify($password, $row['password'])) {
                        if ($row['urole'] == 'admin') {
                            $_SESSION['admin_login'] = $row['id'];
                            $_SESSION['success'] = 'เข้าสู่ระบบสำเร็จ';
                            header("location: admin_homepage.php");
                        } else {
                            $_SESSION['user_login'] = $row['id'];
                            $_SESSION['success'] = 'เข้าสู่ระบบสำเร็จ';
                            header("location: index.php");
                        }
                    } else {
                        $_SESSION['error'] = 'รหัสผ่านผิด';
                        header("location: index.php");
                    }
                } else {
                    $_SESSION['error'] = 'ชื่อผู้ใช้ผิด';
                    header("location: index.php");
                }
            } else {
                $_SESSION['error'] = 'ไม่มีข้อมูลในระบบ';
                header("location: index.php");
            }

        } catch(PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header("location: signin.php");
        }
    }
}
?>
