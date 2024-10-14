<?php
session_start();
if (!isset($_GET['id_product'])) {
    header("location:admin_homepage.php");
    exit();
}

// รับค่า id_product จาก URL
$id_product = $_GET['id_product'];

require_once 'config/conn.php';

// ตรวจสอบข้อมูลในตาราง product_list ก่อน
$query = $conn->prepare("SELECT * FROM product_list WHERE id_product = :id_product");
$query->bindParam(':id_product', $id_product, PDO::PARAM_INT);
$query->execute();

// ตรวจสอบว่าพบข้อมูลใน product_list หรือไม่
if ($query->rowCount() > 0) {
    $product = $query->fetch(PDO::FETCH_ASSOC);
    $table = 'product_list'; // กำหนดตาราง
} else {
    // หากไม่พบใน product_list ให้ตรวจสอบใน list_product_condo แทน
    $query = $conn->prepare("SELECT * FROM product_list_condo WHERE id_product = :id_product");
    $query->bindParam(':id_product', $id_product, PDO::PARAM_INT);
    $query->execute();

    if ($query->rowCount() > 0) {
        $product = $query->fetch(PDO::FETCH_ASSOC);
        $table = 'product_list_condo'; // กำหนดตาราง
    } else {
        echo "ไม่พบรายการอสังหาริมทรัพย์ที่มี id_product = " . htmlspecialchars($id_product);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?></title>
    <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Viewproduct</title>
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
</head>
<body>

<?php



if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];


    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <div class="navbar bg-base-100">
        <div class="flex lg:flex-1">
            <a href="index.php" class="-m-1.5 p-1.5">
                <img class="h-8 w-auto" src="img/home.png" alt="Home">
            </a>
            <strong>
                <h3 style="margin-left: 10px; margin-top: 5px; font-size: 1rem;" class="fm-f">Khai Thoe</h3>
            </strong>
        </div>
        <div class="flex-none gap-2">
            <div class="form-control">
                <h3 class="fm-f">User: <?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></h3>
            </div>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="User Avatar" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <ul tabindex="0" class="z-50 menu menu-sm dropdown-content bg-base-100 rounded-box mt-3 w-52 p-2 shadow">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php
} elseif (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];

   
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :admin_id");
    $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

    <div class="navbar bg-base-100">
        <div class="flex lg:flex-1">
            <a href="index.php" class="-m-1.5 p-1.5">
                <img class="h-8 w-auto" src="img/home.png" alt="Home">
            </a>
            <strong>
                <h3 style="margin-left: 10px; margin-top: 5px; font-size: 1rem;" class="fm-f">Khai Thoe</h3>
            </strong>
        </div>
        <div class="flex-none gap-2">
        <a href="admin_homepage.php" class="text-m font-semibold leading-6 text-gray-900 mx-10">จัดการรายการอสังหาริมทรัพย์</a>
            <div class="form-control">
              
                <h3 class="fm-f">Admin: <?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?></h3>
            </div>
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Admin Avatar" src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <ul tabindex="0" class="z-50 menu menu-sm dropdown-content bg-base-100 rounded-box mt-3 w-52 p-2 shadow">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
<?php
} else {
?>

    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="index.php" class="-m-1.5 p-1.5">
                <img class="h-8 w-auto" src="img/home.png" alt="Home"> 
            </a>
            <strong>
                <h3 style="margin-left: 10px; margin-top: 5px; font-size: 1rem;" class="fm-f">Khai Thoe</h3>
            </strong>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="index.php" class="text-m font-semibold leading-6 text-gray-900">รายการทั้งหมด</a>
            <div class="dropdown">
                <div tabindex="0" role="button" class="text-m font-semibold leading-6">ประเภท</div>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box w-52 p-2 shadow">
                    <li><a href="list_home.php">บ้านเดี่ยว</a></li>
                    <li><a href="list_condo.php">คอนโด</a></li>
                </ul>
            </div>
        </div>
        <button class="btn btn-success mx-5" onclick="my_modal_3.showModal()">เข้าสู่ระบบ</button>
        <dialog id="my_modal_3" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-center text-3xl fm-f">เข้าสู่ระบบ</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <form class="bg-white px-8 pt-6 pb-8 mb-4" method="post" action="signin_db.php">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Username" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="******************" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="signin">เข้าสู่ระบบ</button>
                    </div>
                </form>
                <form method="dialog">
                    <button class="inline-block font-bold text-sm text-blue-500 hover:text-blue-800" onclick="my_modal_2.showModal()">คุณยังไม่มีบัญชี</button>
                </form>
            </div>
        </dialog>
    </nav>
<?php
}
?>


    <div class="container mx-auto my-20 ">
       
    <div class="grid grid-cols-4 grid-rows-3 grid-flow-col gap-5 mx-auto">   
         <div class="col-start-1 col-span-2 row-start-1 row-span-2  ">
         <img src="img/<?php echo $product['product_image']; ?>" class="object-cover rounded-2xl  w-full h-full transition duration-300 ease-in-out">
    </div>    
  
    
    <div class="col-start-3 row-start-1 col-span-2 row-span-2 mx-auto text-wrap ">

    <h1 class="text-[4rem]  fm-f my-5">ชื่อ : <?php echo htmlspecialchars($product['product_name']); ?></h1>
    <p class="text-[1rem] fm-f my-5 text-blue-300 "> <?php echo htmlspecialchars($product['Detail']); ?></p>
    <p></p><p class="text-[2rem]  fm-f my-5">ราคา : <?php echo htmlspecialchars(number_format($product['price'])); ?> บาท</p>
    <p class="text-[1rem] fm-f my-5">ประเภท : <?php echo htmlspecialchars($product['type']); ?> </p>
    <p class="text-[1rem] fm-f my-5">จำนวนห้องนอน : <?php echo htmlspecialchars($product['bedroom']); ?> ห้อง</p>
    <p class="text-[1rem] fm-f my-5">จำนวนห้องน้ำ : <?php echo htmlspecialchars($product['bathroom']); ?> ห้อง</p>
    <p class="text-[1rem] fm-f my-5">เมือง : <?php echo htmlspecialchars($product['city']); ?></p>
    <p class="text-[1rem] fm-f my-5">ที่อยู่ : <?php echo htmlspecialchars($product['address']); ?></p>
    <p class="text-[1rem] fm-f my-5">สถานะสินค้า : <?php echo htmlspecialchars($product['status_product']); ?></p>
    </div>
    <?php
    if(isset($_SESSION['admin_login'])) {
    echo '<button class="btn  btn-neutral col-start-3 col-span-2 row-start-3 my-5 text-[1rem]"> ติดต่อซื้อสินค้า </button>';
    }else if(isset( $_SESSION['user_login'])) {
      echo '<button class="btn  btn-neutral col-start-3 col-span-2 row-start-3 my-5 text-[1rem]" onclick="contactadmin.showModal()"> ติดต่อซื้อสินค้า </button>';
    }else{
      echo '<button class="btn  btn-neutral col-start-3 col-span-2 row-start-3 my-5 text-[1rem]" onclick="login.showModal()"> ติดต่อซื้อสินค้า </button>';
    }
    ?>
   </div> 
</div>


  


   
<dialog id="contactadmin" class="modal">
  <div class="modal-box">
    <h3 class="text-lg font-bold">ติดต่อแอดมินเพื่อทำเรื่อง!</h3>
    <img src="https://apptopi.jp/wp-content/uploads/error-qr.png" alt="contact" class="my-5">
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<dialog id="login" class="modal">
            <div class="modal-box">
                <h3 class="font-bold text-center text-3xl fm-f">เข้าสู่ระบบ</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                </form>
                <form class="bg-white px-8 pt-6 pb-8 mb-4" method="post" action="signin_db.php">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Username" required>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="******************" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="signin">เข้าสู่ระบบ</button>
                    </div>
                </form>

                   <a href="index.php"> <button class="inline-block font-bold text-sm text-blue-500 hover:text-blue-800" >คุณยังไม่มีบัญชี</button></a>
         
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
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            class="fill-current">
            <path
              d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
          </svg>
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
