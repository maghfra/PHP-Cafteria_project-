<?php
session_start(); 
require_once('../config/dbcon.php');

$database = new db(); 

if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

    header("Location: ../login_page/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria</title>
    <link rel="stylesheet" href="../assests/css/home.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"/>
</head>
<body>

<?php require('./includes/navbar.php')?>
   
    <!-- home section -->
    <section class="home">
        <div class="content">
            <h1 class="title">Fresh <span>Coffee</span> in the morning</h1>
            <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, quo! Enim eius nostrum repellat mollitia esse dolorem veritatis, iste libero commodi incidunt nisi. Neque velit iste fugiat iusto, repellendus natus.</p>
            <a href="#products" class="btn"><button>Get started</button></a>
        </div>
    </section>
     <!-- home section -->
     <!-- product section -->
    <div class="container">
        <div class="row">
           <div class="col-md-5">
           <form action="../includes/home_products/processOrderAdmin.php" method="POST">
                    <div class="orders-panel">
                        <div class="user-selection">
                           <label>Select User:</label>
                           <select name="selected_user_id" class="form-select my-3">
                            <?php
                              $users_query = "SELECT user_id, name FROM users WHERE role = 'user'";
                              $users_result = $database->getdata("user_id, name", "users", "role='user'");
                              if ($users_result) {
                                  while ($row = $users_result->fetch_assoc()) {
                                      echo "<option value='" . $row['user_id'] . "'>" . $row['name'] . "</option>";
                                    }
                                } else {
                                   echo "<option value=''>No users found</option>";
                                }
                            ?>
                            </select>
                        </div>
                        <!-- choosen-items -->
                        <div class="choosen-items">
                            <ul class="list-unstyled">
                                <!-- item-info -->
                      
                                <!--  item info -->
                            </ul>
                        </div>
                        <!-- ./choosen-items -->
                        <!-- items-notes -->
                        <div class="items-notes">
                            <label>Notes</label>
                            <textarea name="notes"></textarea>
                        </div>
                        <!-- ./items-notes -->
                        <!-- room -->
                        <div class="room">
                            <label>Room</label>
                            <select name="room_id" class="form-select">
                               <?php
                                  $rooms_query = "SELECT * FROM rooms";
                                  $rooms_result = $database->getdata("*", "rooms", "");
                                 if ($rooms_result) {
                                    while ($row = $rooms_result->fetch_assoc()) {
                                        echo "<option value='".$row['room_id']."'>".$row['room_number']."</option>";
                                    }
                                } else {
                                   echo "<option value=''>No rooms found</option>";
                                }
                                ?>
                           </select>
                        </div>
                        <!-- ./room -->
                        <!-- total-price -->
                        <div class="total-price">
                            <span>EGP <span>0</span></span>
                            <input type="text" name="amount" value="" hidden />
                        </div>
                        <!-- ./total-price -->
                        <!-- confirm -->
                        <div class="confirm">
                            <input type="submit" name="submit" value="confirm" class="btn btn-success">
                        </div>
                        <!-- confirm -->
                    </div>
                </form>
          </div>
          <div class="col-md-7">
               <div class="allProducts ">
                 <div class="products" id="products">
                      <h1>Main menu</h1>
                      <div class="row">
                      <?php include  ('../includes/home_products/allproducts.php')?>
                     </div>
                 </div>
             </div>
           </div>
       </div>
    </div>
    <script src="../assests/js/home.js"></script>
</body>
</html>
