<?php 
ob_start();
session_start();
//var_dump($_SESSION);
include('includes/header.php')?>

<?php
// Include the file containing the db class
require('../config/dbcon.php');

// Create database object
$database = new db();
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

    header("Location: ../login_page/login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"];
include('includes/navbar.php');

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Validation
    $errors = array();

    // Name validation
    if(empty($_POST['name'])) {
        $errors['name'] = 'Name field is required';
    }       
    // price validation
   if(empty($_POST['price'])) {
        $errors['price'] = 'Price field is required';
     }
    // Image validation
    if ($_FILES['image']['error'] != UPLOAD_ERR_OK) {
        $errors['image'] = 'Image is required';
    }


    // Status validation
    if(empty($_POST['status'])) {
        $errors['status'] = 'Status field is required';
    }

    // If no validation errors, proceed with database insertion
    if(empty($errors)) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $status= $_POST['status'];
        $categoryid = $_POST["category_id"];

        // Image upload
        if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_destination = 'assests/images/' . $file_name;

        // Move the uploaded file to the destination folder
        if (!move_uploaded_file($file_tmp, $file_destination)) {
            $errors['image'] = "Failed to move uploaded file.";
        }

        // Insert data into the database
       
        $tableName = 'products';
        $columns = ['name', 'price', 'image', 'category_id', 'status']; 
        $values = [$name, $price, $file_name, $categoryid, $status]; 
        $result = $database->insert_data($tableName, $columns, $values);

        if($result) {
            $_SESSION['message'] = "Product added successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to add Product";
            $_SESSION['message_type'] = "error";
        }
    } else {
        // If there are validation errors, store them in session
        $_SESSION['errors'] = $errors;
        
    }
}

}
?>



<div class="container mt-3">
<h1 class="mt-4 text-center">Add Product</h1>

<div class="d-flex justify-content-center align-items-center my-4">
        <div class="col-md-6">
        <div class="card p-3">
                <div >
                    <div  ">
                        <div >
                            <form method="post" enctype="multipart/form-data">  
                                <div class="form-group  mb-3">
                                    <label for="name" class="mb-2">Name:</label>
                                    <input type="text" name="name" class="form-control">
                                <?php if(isset($errors['name'])): ?>
                                    <small class="text-danger"><?php echo $errors['name']; ?></small>
                                 <?php endif; ?>
                                </div>
                                <div class="form-group  mb-3">
                                    <label for="price " class="mb-2">Price:</label>
                                    <div class="col-md-6 input-group">
                                        <input class="form-control"
                                            type="number"
                                            name="price"
                                            min="0.00"
                                            max="10000.00"
                                            placeholder="0.0"
                                        />
                                        <span class="input-group-append m-2 ">EGP</span>
                                    </div>
                                    </div>
                                    <?php if(isset($errors['price'])): ?>
                                        <small class="text-danger"><?php echo $errors['price']; ?></small>
                                    <?php endif; ?>
                                <div class="form-group  mb-3">
                                    <label for="category_id" class="mb-2">Category:</label>
                                    <div class="col-md-6 input-group">
                                    <select name="category_id" class="form-select"> 
                                        <?php
                                        // Fetch categories from the database
                                        $categories_query = "SELECT * FROM categories";
                                        $categories_result = $database->getdata("*", "categories", "");
                                        if ($categories_result) {
                                            while ($row = $categories_result->fetch_assoc()) {
                                                echo "<option value='".$row['category_id']."'>".$row['name']."</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No categories found</option>";
                                        }
                                        ?>
                                    </select> <span class="input-group-append m-2 "><a href="add_catogray.php" class=" text-decoration-none category">Add New Category</a></span>
                                </div>
                                <div class="form-group  mb-3">
                                    <label for="status" class="mb-2">Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="available">Available</option>
                                        <option value="unavailable">Unavailable</option>
                                    </select>
                                </div>
                                <div class="form-group  mb-3 ">
                                    <label for="image" class="mb-2">Image:</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <?php if(isset($errors['image'])): ?>
                                        <small class="text-danger"><?php echo $errors['image']; ?></small>
                                    <?php endif; ?>
                                <div class="form-group">
                                    <button type="submit" name="submit" class="btn" id='thebutton'>Submit</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </form>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ob_end_flush()?>
<?php include('includes/footer.php')?>
