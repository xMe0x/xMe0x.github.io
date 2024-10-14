<?php
session_start();
require_once 'config/conn.php';

if (isset($_POST['delete'])) {
    $id_product = $_POST['id_product'];
    $type = isset($_POST['type']) ? $_POST['type'] : 'บ้านเดี่ยว'; 

    if($type == "คอนโด"){
        $stmt = $conn->prepare("DELETE FROM product_list_condo WHERE id_product = :id_product");
        $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
    }else{
    // ลบ product จากฐานข้อมูล
    $stmt = $conn->prepare("DELETE FROM product_list WHERE id_product = :id_product");
    $stmt->bindParam(':id_product', $id_product, PDO::PARAM_INT);
        }
    if ($stmt->execute()) {
        $_SESSION['success'] = "ลบข้อมูลสำเร็จ!";
    } else {
        $_SESSION['error'] = "เกิดข้อผิดพลาดในการลบข้อมูล!";
    }

    // กลับไปที่หน้า admin homepage
    header("Location: admin_homepage.php");
    exit();
}
?>