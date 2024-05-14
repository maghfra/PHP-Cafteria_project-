<?php 
ob_start();
session_start();
include('includes/header.php');

// Clear session errors
unset($_SESSION['errors']);
?>
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
    $errors = array();

    // Name validation
    if(empty($_POST['name'])) {
        $errors['name'] = 'Name field is required';
    }

   if(empty($_POST['price'])) {
    $errors['price'] = 'Price field is required';
 }

if(empty($_POST['status'])) {
    $errors['status'] = 'Status field is required';
}

if(empty($errors)) {
    $id=$_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $status= $_POST['status'];
    $categoryid = $_POST["category_id"];  // get
    $values = ['name' => $name, 'price' => $price, 'category_id' => $categoryid, 'status' => $status]; 

    // Check if image is uploaded
    if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_destination = 'assests/images/' . $file_name;

        // Move the uploaded file to the destination folder
        if (!move_uploaded_file($file_tmp, $file_destination)) {
            $errors['image'] = "Failed to move uploaded file.";
        } else {
            $values['image'] = $file_name; // Update image value in $values array
        }
    } else {
        $errors['image'] = "Image upload failed.";
    }

    // Update data in the database
    $tableName = 'products';
    $condition = "product_id=$id"; // Condition to identify the row to update
    $result = $database->update_data($tableName, $values, $condition);
 
    if($result) {
        $_SESSION['message'] = "Product Updated successfully";
        $_SESSION['message_type'] = "success";
        // Clear session errors after successful submission
        unset($_SESSION['errors']);
    } else {
        $_SESSION['message'] = "Failed to Update Product";
        $_SESSION['message_type'] = "error";
    }
} 
    else {
        // If there are validation errors, store them in session
        $_SESSION['errors'] = $errors;
        
    }
    
    }



// Fetch product details for editing
if(isset($_GET["id"])) {
    $product_id = $_GET["id"]; // Fetch product_id from the URL

    $product = $database->getbyid("products", $product_id);
   
    if ($product && $product->num_rows > 0) {
        $row = $product->fetch_assoc(); // Fetch the product details
?>
        <div class="container">
            <div class="row">
                <div class="">
                    <div class="container">
                     
                            <h1 class="mt-4 text-center">Edit Product</h1>
                        
                            <div class="d-flex justify-content-center align-items-center my-4">
                            <div class="col-md-6">
                            <div class="card p-3">
                                    <form method="post" enctype="multipart/form-data">  
                                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

                                         <div class="form-group mb-3">
                                            <label for="name" class="mb-2">Name:</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>">
                                            <?php if(isset($_SESSION['errors']['name'])): ?>
                                                <small class="text-danger"><?php echo $_SESSION['errors']['name']; ?></small>
                                            <?php endif; ?>
                                         </div>
                                        <div class="form-group mb-3">
                                            <label for="price " class="mb-2">Price:</label>
                                            <div class="col-md-6 input-group">
                                                <input class="form-control"
                                                    type="number"
                                                    name="price"
                                                    min="0.00"
                                                    max="10000.00"
                                                    placeholder="0.0"
                                                    value="<?php echo $row['price']; ?>"
                                                />
                                                <span class="input-group-append m-2 ">EGP</span>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3 ">
                                            <label for="category_id" class="mb-2">Category:</label>
                                            <div class="col-md-6 input-group ">
                                                <select name="category_id" class="form-select"> 
                                                    <?php
                                                    // Fetch categories from the database
                                                    $categories_query = "SELECT * FROM categories";
                                                    $categories_result = $database->getdata("*", "categories", "");
                                                    if ($categories_result) {
                                                        while ($category_row = $categories_result->fetch_assoc()) {
                                                            $selected = ($category_row['category_id'] == $row['category_id']) ? 'selected' : '';
                                                            echo "<option value='".$category_row['category_id']."' $selected>".$category_row['name']."</option>";
                                                        }
                                                    } else {
                                                        echo "<option value=''>No categories found</option>";
                                                    }
                                                    ?>
                                                </select> <span class="input-group-append  m-2 "><a href="add_catogray.php" class=" text-decoration-none category">Add New Category</a></span>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="status" class="mb-2">Status:</label>
                                            <select name="status" class="form-control">
                                                <option value="available" <?php echo ($row['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                                                <option value="unavailable" <?php echo ($row['status'] == 'unavailable') ? 'selected' : ''; ?>>Unavailable</option>
                                            </select>
                                            <?php if(isset($_SESSION['errors']['status'])): ?>
                                                <small class="text-danger"><?php echo $_SESSION['errors']['status']; ?></small>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="form-group mb-3">
                                            <label for="image" class="mb-2">Image:</label>
                                            <input type="file" name="image" class="form-control">
                                            <?php if(isset($_SESSION['errors']['image'])): ?>
                                                <small class="text-danger"><?php echo $_SESSION['errors']['image']; ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group my-3">
                                            <button type="submit" name="submit" class="btn" id='thebutton'>Update </button>
                                        </div>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo "Product not found for the provided ID.";
    }
} 
else {
    echo "ID is missing from the URL.";
}

?>
<?php ob_end_flush()?>

<?php include('includes/footer.php')?>