<?php
session_start();
require_once 'config/conn.php';

if(isset($_POST['insert'])){

    $price = $_POST['price'];
    $Detail = $_POST['Detail'];
    $city = $_POST['city'];
    $status_product = $_POST['status_product'];
    $date_listed = $_POST['date_listed'];
    $address = $_POST['address'];
    $bedroom = $_POST['bedroom'];
    $bathroom = $_POST['bathroom'];
    $type = $_POST['type'];
    $product_name = $_POST['product_name'];

    if(isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK){
        $image_name = $_FILES['product_image']['name'];
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $folder = 'img/';
        $image_location = $folder.$image_name;
        move_uploaded_file($image_tmp, $image_location);
        
        if($type == "คอนโด"){
            $stmt = $conn->prepare("INSERT INTO product_list_condo (product_name, Detail, price, bedroom, bathroom,product_image,city,status_product,address,type,date_listed) VALUES (:product_name, :detail, :price, :bedroom, :bathroom, :product_image, :city, :status_product, :address, :type, :date_listed)");

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
        } else {
            $stmt = $conn->prepare("INSERT INTO product_list (product_name, Detail, price, bedroom, bathroom,product_image,city,status_product,address,type,date_listed) VALUES (:product_name, :detail, :price, :bedroom, :bathroom, :product_image, :city, :status_product, :address, :type, :date_listed)");

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
        }

        if($stmt->execute()) {
            $_SESSION['success'] = 'เพิ่มข้อมูลสำเร็จ';
            header("location:admin_homepage.php");
            exit();
        } else {
            $_SESSION['error'] = 'มีข้อผิดพลาด';
            header("location:admin_homepage.php");
            exit();
        }

        $stmt->close();
    } else {
        echo "การอัปโหลดไฟล์ล้มเหลว.";
        echo '<pre>';
print_r($_FILES);
echo '</pre>';
    }
}
?>
