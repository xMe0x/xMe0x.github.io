<?php
session_start();
require_once 'config/conn.php';

if (!isset($_SESSION['admin_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบก่อน !';
  header('location:index.php');
}

$query = $conn->query("SELECT * FROM product_list");
$rows = $query->rowCount(); // ใช้ rowCount() แทน mysqli_num_rows

$query_condo = $conn->query("SELECT * FROM product_list_condo");
$rows_condo = $query_condo->rowCount(); // ใช้ rowCount() แทน mysqli_num_rows
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AdminHomepage</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Concert+One&family=Mitr:wght@200;300;400;500;600;700&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.11/dist/full.min.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="output.css">
  <link rel="stylesheet" href="style_index.css">

  <style>


.card-container {
    display: flex;
    flex-wrap: wrap; /* ทำให้การ์ดไม่เกินพื้นที่ */
    gap: 16px; /* ระยะห่างระหว่างการ์ด */
}

.max-w-md {
    flex: 1 1 300px; /* กำหนดขนาดขั้นต่ำของการ์ด */
    min-height: 400px; /* หรือกำหนดความสูงขั้นต่ำ */
}
  </style>
</head>

<body>

  <?php
  if (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];
    $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  ?>

  <div class="navbar bg-base-100">
    <div class="flex lg:flex-1">
      <a href="index.php" class="-m-1.5 p-1.5">
        <img class="h-8 w-auto" src="img/home.png" alt="">
      </a>
      <strong>
        <h3 style="margin-left: 10px; margin-top: 5px; font-size: 1rem;" class="fm-f">Khai Thoe</h3>
      </strong>
    </div>
    <div class="flex-none gap-2">
      <div class="form-control">
        <h3 class="fm-f">Admin : <?php echo $row['firstname'] . ' ' . $row['lastname']; ?></h3>
      </div>
      <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img alt="Tailwind CSS Navbar component"
              src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
          </div>
        </div>
        <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z- mt-3 w-52 p-2 shadow">
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="logo bg-gray-800 border-5 p-10 text-white">
    <h1 class="fm-f text-5xl text-center my-10">Welcome to homepage for Admin</h1>
    <h3 class="fm-f text-3xl text-center">ยินดีต้อนรับเข้าสู่หน้าแรกของแอดมิน</h3>
  </div>
  <?php
  if (isset($_SESSION['success'])) {
    echo "<script>alert('" . $_SESSION['success'] . "');</script>";
    unset($_SESSION['success']);
  }
  if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
  }
  ?>
<div class="container mx-auto">
    <h2 class="fm-f text-2xl my-10">รายการบ้านเดี่ยว ที่อยู่ในระบบ :</h2>
    <div class="container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 my-10" id="product">
    
      <?php
      if ($rows > 0) {
        while ($product = $query->fetch(PDO::FETCH_ASSOC)) {
          
          echo '<div class="max-w-md w-full">';
          echo '    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden hover:shadow-3xl">';
          echo '<a href="view_product_home.php?id_product=' . $product["id_product"] . '">';
          echo '     <div class="relative group">';
          echo '        <img src="img/'.$product['product_image'].'" class="object-cover w-full h-48 group-hover: transition duration-300 ease-in-out">'; 
          echo '<div class="absolute top-4 right-4 bg-gray-100 text-xs font-bold px-3 py-2 rounded-full z-20 fm-f transform rotate-12">'.htmlspecialchars($product['status_product']).'</div>';
          echo '        <div class="hover:bg-gray-600 group-hover:translate-y-0 pb-10 transform transition duration-300 ease-in-out absolute inset-0 bg-gradient-to-br to-indigo-600 opacity-75 flex items-center justify-center">';
          echo '            <span class="text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">กดเพื่อดู</span>';
          echo '        </div>';
          echo '    </div>';
          echo '      </a>';
          echo '        <div class="p-6 h-60">';
          echo '            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">' . htmlspecialchars($product['product_name']) . '</h2>';
          echo '            <p class="text-gray-600 mb-4">' . htmlspecialchars($product['Detail']) . '</p>';
          echo '            <div class="flex items-center justify-between mb-4">';
          echo '                <p>ราคา : </p>';
          echo '                <span class="text-1xl font-bold text-indigo-600">' .htmlspecialchars(number_format($product['price'])) . '</span>';
          echo '                <div class="flex items-center">';
          echo '                    <p>จำนวนห้อง : </p>';
          echo '                    <span class="ml-1 text-gray-600">' . htmlspecialchars($product['bedroom']) . ' นอน ' . htmlspecialchars($product['bathroom']) . ' น้ำ</span>';
          echo '                </div>';
          echo '            </div>';
          echo '            <div class="grid grid-cols-2 gap-2">';
          echo '<button class="w-full bg-yellow-300 text-white font-bold py-3 px-4 rounded-lg hover:bg-yellow-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg open-modal" data-id="' . htmlspecialchars($product['id_product']) . '" onclick="my_modal_1.showModal()">แก้ไข</button>';
          echo ' <form action="delete_product.php" method="post" onsubmit="return confirmDelete();">';
          echo '<input type="hidden" name="type" value="' . ($product['type']) . '">';
          echo '<input type="hidden" name="id_product" value="' . ($product['id_product']) . '">';
          echo ' <button class="w-full bg-red-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-red-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg" type="submit" name="delete">';
          echo '    ลบ';
          echo ' </button>';
          echo ' </form>';
          echo '            </div>';
          echo '        </div>';
          echo '    </div>';
          echo '</div>';
        }
      } else {
        echo "<p>ไม่มีรายการอสังหาริมทรัพย์</p>";
      }
      ?>

    </div>
</div>
    <?php
    if (isset($_SESSION['success'])) {
      echo "<script>alert('" . $_SESSION['success'] . "');</script>";
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
      echo "<script>alert('" . $_SESSION['error'] . "');</script>";
      unset($_SESSION['error']);
    }
    ?>
    <div class="container mx-auto">
    <h2 class="fm-f text-2xl my-10">รายการคอนโด ที่อยู่ในระบบ :</h2>
<div class="container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 my-10" id="product">

  <?php
  if ($rows_condo > 0) {
    while ($product_condo = $query_condo->fetch(PDO::FETCH_ASSOC)) {

      echo '<div class="max-w-md w-full">';
      echo '    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden hover:shadow-3xl">';
      echo '<a href="view_product_home.php?id_product=' . $product_condo["id_product"] . '">';
      echo '     <div class="relative group">';
      echo '        <img src="img/' . $product_condo['product_image'] . '" class="object-cover w-full h-48 group-hover:transition duration-300 ease-in-out">'; // Fixed height for images
      echo '<div class="absolute top-4 right-4 bg-gray-100 text-xs font-bold px-3 py-2 rounded-full z-20 transform rotate-12 fm-f">' . htmlspecialchars($product_condo['status_product']) . '</div>';
      echo '        <div class="hover:bg-gray-600 group-hover:translate-y-0 pb-10 transform transition duration-300 ease-in-out absolute inset-0 bg-gradient-to-br to-indigo-600 opacity-75 flex items-center justify-center">';
      echo '            <span class="text-white text-lg font-bold opacity-0 group-hover:opacity-100 transition duration-300 ease-in-out">กดเพื่อดู</span>';
      echo '        </div>';
      echo '    </div>';
      echo '      </a>';
      echo '        <div class="p-6 h-60">'; 
      echo '            <h2 class="text-3xl font-extrabold text-gray-800 mb-2">' . htmlspecialchars($product_condo['product_name']) . '</h2>';
      echo '            <p class="text-gray-600 mb-4">' . htmlspecialchars($product_condo['Detail']) . '</p>';
      echo '            <div class="flex items-center justify-between mb-4">';
      echo '                <p>ราคา : </p>';
      echo '                <span class="text-1xl font-bold text-indigo-600">' . htmlspecialchars(number_format($product_condo['price'])) . '</span>';
      echo '                <div class="flex items-center">';
      echo '                    <p>จำนวนห้อง : </p>';
      echo '                    <span class="ml-1 text-gray-600">' . htmlspecialchars($product_condo['bedroom']) . ' นอน ' . htmlspecialchars($product_condo['bathroom']) . ' น้ำ</span>';
      echo '                </div>';
      echo '            </div>';
      echo '            <div class="grid grid-cols-2 gap-2">';
      
      echo '<button class="w-full bg-yellow-300 text-white font-bold py-3 px-4 rounded-lg hover:bg-yellow-500 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg open-modal-1" data-id-1="' . htmlspecialchars($product_condo['id_product']) . '">แก้ไข</button>';

      echo ' <form action="delete_product.php" method="post" onsubmit="return confirmDelete();">';
      echo '<input type="hidden" name="type" value="' . ($product_condo['type']) . '">';
      echo '<input type="hidden" name="id_product" value="' . ($product_condo['id_product']) . '">';
      echo ' <button class="w-full bg-red-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-red-700 transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg" type="submit" name="delete">';
      echo '    ลบ';
      echo ' </button>';
      echo ' </form>';
      echo '            </div>';
      echo '        </div>';
      echo '    </div>';
      echo '</div>';
    }
  } else {
    echo "<p>ไม่มีรายการอสังหาริมทรัพย์</p>";
  }
  ?>
  </div>
</div>
      <script>document.querySelectorAll('.open-modal').forEach(button => {
          button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            document.getElementById('my_modal_1').setAttribute('data-id', productId);
            // เปิด modal
            my_modal_1.showModal();
          });
        });</script>
      <script>
        function confirmDelete() {
          return confirm('คุณแน่ใจว่าต้องการลบสินค้านี้หรือไม่? การลบนี้ไม่สามารถย้อนกลับได้');
        }
      </script>

      <script>

        document.querySelectorAll('.open-modal').forEach(button => {
          button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            document.getElementById('my_modal_1').setAttribute('data-id', productId);
            // ตั้งค่า value ของ input field
            document.getElementById('id_product').value = productId;
            // เปิด modal
            my_modal_1.showModal();
          });
        });
      </script>
      
      <script>
    document.querySelectorAll('.open-modal-1').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id-1');
            document.getElementById('my_modal_3').setAttribute('data-id-1', productId);
            // ตั้งค่า value ของ input field
            document.getElementById('id_product1').value = productId;
            // เปิด modal
            document.getElementById('my_modal_3').showModal();
        });
    });
</script>

      <button class="btn btn-primary fixed bottom-4 right-4 text-white" onclick="my_modal_2.showModal()">
        เพิ่มรายการอสังหาริมทรัพย์
      </button>
      <dialog id="my_modal_2" class="modal">
        <div class="modal-box">
          <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
          </form>
          <h3 class="text-lg font-bold my-5 text-center fm-f text-10xl">กรอกข้อมูลอสังหาริมทรัพย์ !</h3>
          <form class="w-full max-w-lg" method="post" action="insert_db.php" enctype="multipart/form-data">
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                  ชื่ออสังหาริมทรัพย์
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                  name="product_name" id="grid-first-name" type="text" placeholder="บ้านดี" require="">
              </div>
              <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                  ราคา
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-last-name" type="number" name="price" placeholder="99999 บาท"  required="">
              </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                  รายละเอียดบ้านเพิ่มเติม
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-password" name="Detail" type="text" placeholder="รายละเอียดบ้าน"  required="">
              </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                  ที่อยู่
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-password" name="address" type="text" placeholder="บ้านเลขที่ ตำบล อำเภอ หมู่ อื่นๆ" required="">
              </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-2">
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                  จังหวัด
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  name="city" id="grid-city" type="text" placeholder="เช่น  เพชรบูรณ์ "  required="">
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                  จำนวนห้องนอน
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-city" name="bedroom" type="number" placeholder="3"  required="">
              </div>

              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                  จำนวนห้องน้ำ
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-zip" name="bathroom" type="text" placeholder="1"  required="">
              </div>
            </div>
            <br>
            <div class="flex flex-wrap -mx-3 mb-2">
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                  ประเภท
                </label>
                <div class="relative">
                  <select
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state" name="type" >
                    <option value="บ้านเดี่ยว">บ้านเดี่ยว</option>
                    <option value="คอนโด">คอนโด</option>
                  </select>
                </div>
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                  สถานะการขาย
                </label>
                <div class="relative">
                  <select
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state" name="status_product">
                    <option>ยังไม่ขาย</option>
                  </select>
                </div>
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                  วันที่ลงประกาศ
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-zip" name="date_listed" type="date" placeholder="1"  required="">
              </div>

            </div>
            <br>
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                  รูปภาพอสังหาริมทรัพย์
                </label>
                <input type="file" name="product_image" accept="image/png,image/jpg,image/jpeg"
                  class="file-input file-input-bordered file-input-primary w-full max-w-xs"  required="" />
              </div>
            </div>
            <button class="btn btn-success flex mx-auto my-10 " type="submit" name="insert">เพิ่มข้อมูลสำเร็จ</button>
          </form>
        </div>
      </dialog>

      <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
          <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
          </form>
          <h3 class="text-lg font-bold my-5 text-center fm-f text-10xl">แก้ไขข้อมูลอสังหาริมทรัพย์ !</h3>
          <form class="w-full max-w-lg" method="post" action="edit_db.php" enctype="multipart/form-data">
            <input type="hidden" name="id_product" id="id_product">
            <input type="hidden" name="type" value="บ้านเดี่ยว">
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                  ชื่ออสังหาริมทรัพย์
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                  name="product_name" id="grid-first-name" type="text" placeholder="บ้านดี" require="">
              </div>
              <div class="w-full md:w-1/2 px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                  ราคา
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-last-name" type="number" name="price" placeholder="99999 บาท">
              </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                  รายละเอียดบ้านเพิ่มเติม
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-password" name="Detail" type="text" placeholder="รายละเอียดบ้าน">
              </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                  ที่อยู่
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-password" name="address" type="text" placeholder="บ้านเลขที่ ตำบล อำเภอ หมู่ อื่นๆ">
              </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-2">
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                  จังหวัด
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  name="city" id="grid-city" type="text" placeholder="เช่น  เพชรบูรณ์ ">
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                  จำนวนห้องนอน
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-city" name="bedroom" type="number" placeholder="3">
              </div>

              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                  จำนวนห้องน้ำ
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-zip" name="bathroom" type="text" placeholder="1">
              </div>
            </div>
            <br>
            <div class="flex flex-wrap -mx-3 mb-2">
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                  สถานะการขาย
                </label>
                <div class="relative">
                  <select
                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state" name="status_product">
                    <option>ยังไม่ขาย</option>
                    <option>ขายแล้ว</option>
                  </select>
                </div>
              </div>
              <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                  วันที่ลงประกาศ
                </label>
                <input
                  class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                  id="grid-zip" name="date_listed" type="date" placeholder="1">
              </div>

            </div>
            <br>
            <div class="flex flex-wrap -mx-3 mb-6">
            <div class="flex flex-wrap -mx-3 mb-6">
              <div class="w-full px-3">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                  รูปภาพอสังหาริมทรัพย์
                </label>
                <input type="file" name="product_image" accept="image/png,image/jpg,image/jpeg"
                  class="file-input file-input-bordered file-input-primary w-full max-w-xs" />
              </div>
            </div>
            </div>
            <button class="btn btn-success flex mx-auto my-10 " type="submit" name="edit">แก้ไขสำเร็จ</button>
          </form>
        </div>
      </dialog>

      <dialog id="my_modal_3" class="modal">
    <div class="modal-box">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        <h3 class="text-lg font-bold my-5 text-center fm-f text-10xl">แก้ไขข้อมูลอสังหาริมทรัพย์ !</h3>
        <form class="w-full max-w-lg" method="post" action="edit_db.php" enctype="multipart/form-data">
            <input type="hidden" name="id_product1" id="id_product1">
            <input type="hidden" name="type" value="คอนโด"> <!-- เพิ่มฟิลด์ hidden สำหรับ type -->
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                        ชื่ออสังหาริมทรัพย์
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        name="product_name" id="grid-first-name" type="text" placeholder="บ้านดี" require="">
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                        ราคา
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-last-name" type="number" name="price" placeholder="99999 บาท">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                        รายละเอียดบ้านเพิ่มเติม
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-password" name="Detail" type="text" placeholder="รายละเอียดบ้าน">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                        ที่อยู่
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-password" name="address" type="text" placeholder="บ้านเลขที่ ตำบล อำเภอ หมู่ อื่นๆ">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                        จังหวัด
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        name="city" id="grid-city" type="text" placeholder="เช่น  เพชรบูรณ์ ">
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-city">
                        จำนวนห้องนอน
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-city" name="bedroom" type="number" placeholder="3">
                </div>

                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        จำนวนห้องน้ำ
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-zip" name="bathroom" type="text" placeholder="1">
                </div>
            </div>
            <br>
            <div class="flex flex-wrap -mx-3 mb-2">
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        สถานะการขาย
                    </label>
                    <div class="relative">
                        <select
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state" name="status_product">
                            <option>ยังไม่ขาย</option>
                            <option>ขายแล้ว</option>
                        </select>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-zip">
                        วันที่ลงประกาศ
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-zip" name="date_listed" type="date" placeholder="1">
                </div>
            </div>
            <br>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                        รูปภาพอสังหาริมทรัพย์
                    </label>
                    <input type="file" name="product_image" accept="image/png,image/jpg,image/jpeg"
                        class="file-input file-input-bordered file-input-primary w-full max-w-xs" />
                </div>
            </div>
            <button class="btn btn-success flex mx-auto my-10" type="submit" name="edit">แก้ไขสำเร็จ</button>
        </form>
    </div>
</dialog>


<div class="footer">
  <footer class="footer footer-center bg-neutral text-primary-content p-10">
    <aside>
      <img src="img/home.png" alt="" style="width: 50px; height: 50px;">
      <p class="font-bold">
        Khai Thoe ขายเถอะ
        <br />
        เว็บขายบ้านที่ เด็ก COMSCI แนะนำเป็นอันดับ 1
      </p>
      <p>Product by : Webgen      </p>
    </aside>
    <nav>
      <div class="grid grid-flow-col gap-4">
        <a>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current">
            <path
              d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path>
          </svg>
        </a>
        <a>
        <a>
  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" id="ig" viewBox="0 0 20 20" class="fill-current">
  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
  </svg>
</a>
        </a>
        <a>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current">
            <path
              d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
          </svg>
        </a>
      </div>
    </nav>
  </footer>
</div>
</body>

</html>