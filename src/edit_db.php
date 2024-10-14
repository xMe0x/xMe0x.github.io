<?php
session_start();
require_once 'config/conn.php';

if(isset($_POST['edit'])){
    $type = isset($_POST['type']) ? $_POST['type'] : 'บ้านเดี่ยว'; 
    if($type == "คอนโด"){
    $id_product = $_POST['id_product1'];
    }else {
        $id_product = $_POST['id_product'];
    }

    // ตรวจสอบค่า type
    echo "Type: " . $type . "<br>";
    echo "ID Product: " . $id_product . "<br>";

    // ดึงข้อมูลปัจจุบันจากฐานข้อมูล
    if($type == "คอนโด"){
        $stmt = $conn->prepare("SELECT * FROM product_list_condo WHERE id_product = :id_product");
    } else {
        $stmt = $conn->prepare("SELECT * FROM product_list WHERE id_product = :id_product");
    }
    $stmt->bindValue(':id_product', $id_product);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product){
        $_SESSION['error'] = 'ไม่พบข้อมูลในฐานข้อมูล';
        
        exit();
    }

    // ใช้ค่าจากฟอร์มหากมีการส่งมา
    $price = !empty($_POST['price']) ? $_POST['price'] : $product['price'];
    $Detail = !empty($_POST['Detail']) ? $_POST['Detail'] : $product['Detail'];
    $city = !empty($_POST['city']) ? $_POST['city'] : $product['city'];
    $status_product = !empty($_POST['status_product']) ? $_POST['status_product'] : $product['status_product'];
    $date_listed = !empty($_POST['date_listed']) ? $_POST['date_listed'] : $product['date_listed'];
    $address = !empty($_POST['address']) ? $_POST['address'] : $product['address'];
    $bedroom = !empty($_POST['bedroom']) ? $_POST['bedroom'] : $product['bedroom'];
    $bathroom = !empty($_POST['bathroom']) ? $_POST['bathroom'] : $product['bathroom'];
    $product_name = !empty($_POST['product_name']) ? $_POST['product_name'] : $product['product_name'];

    $image_name = $product['product_image'];
    if(isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK){
        $image_name = $_FILES['product_image']['name'];
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $folder = 'img/';
        $image_location = $folder.$image_name;
        move_uploaded_file($image_tmp, $image_location);
    }
    if($type=="คอนโด"){
    // ทำการอัปเดตข้อมูลในตารางเดียวกัน
    $stmt = $conn->prepare("UPDATE product_list_condo SET product_name = :product_name, Detail = :detail, price = :price, bedroom = :bedroom, bathroom = :bathroom, product_image = :product_image, status_product = :status_product, city = :city, address = :address, type = :type, date_listed = :date_listed WHERE id_product = :id_product");

    $stmt->bindValue(':product_name', $product_name);
    $stmt->bindValue(':detail', $Detail);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':bedroom', $bedroom);
    $stmt->bindValue(':bathroom', $bathroom);
    $stmt->bindValue(':product_image', $image_name);
    $stmt->bindValue(':city', $city);
    $stmt->bindValue(':status_product', $status_product);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':type', $type);
    $stmt->bindValue(':date_listed', $date_listed);
    $stmt->bindValue(':id_product', $id_product);
    }else{
        $stmt = $conn->prepare("UPDATE product_list SET product_name = :product_name, Detail = :detail, price = :price, bedroom = :bedroom, bathroom = :bathroom, product_image = :product_image, status_product = :status_product, city = :city, address = :address, type = :type, date_listed = :date_listed WHERE id_product = :id_product");

        $stmt->bindValue(':product_name', $product_name);
        $stmt->bindValue(':detail', $Detail);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':bedroom', $bedroom);
        $stmt->bindValue(':bathroom', $bathroom);
        $stmt->bindValue(':product_image', $image_name);
        $stmt->bindValue(':city', $city);
        $stmt->bindValue(':status_product', $status_product);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':date_listed', $date_listed);
        $stmt->bindValue(':id_product', $id_product);

    }
    if($stmt->execute()) {
        $_SESSION['success'] = 'แก้ไขข้อมูลสำเร็จ';
        header("location:admin_homepage.php");
        exit();
    } else {
        $_SESSION['error'] = 'มีข้อผิดพลาด';
        header("location:admin_homepage.php");
        exit();
    }

    $stmt->close();
}
?>

