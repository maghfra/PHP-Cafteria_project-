<?php
 //var_dump($_SESSION);

 ob_start();
 session_start(); 
?>

<?php
require('../config/dbcon.php');
if (!isset($_SESSION["user_id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {

    header("Location: ../login_page/login.php");
    exit();
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$image = $_SESSION["image"];

if(isset($_POST['submit'])) {
    // Validation
    $errors = array();

    // Name validation
    if(empty($_POST['name'])) {
        $errors[] = 'Name field is required';
    } else {
        $name = $_POST['name'];
        // Check if name is within the allowed length
        if(strlen($name) < 2 || strlen($name) > 50) {
            $errors[] = 'Name must be between 2 and 50 characters';
        }
    }

    // If no validation errors, proceed with database insertion
    if(empty($errors)) {
        // Create database object
        $database = new db();
        
        // Insert data into the database
        $tableName = 'categories';
        $columns = ['name'];
        $values = [$name];
        $result = $database->insert_data($tableName, $columns, $values);
        
          
        if($result) {
            $_SESSION['message'] = "Category added successfully";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to add category";
            $_SESSION['message_type'] = "error";
        }
    }

     else {
        // If there are validation errors, display them
        foreach($errors as $error) {
            $_SESSION['message'] = $error;
            $_SESSION['message_type'] = "error";
        }
    }


}

?>

<?php include('includes/navbar.php') ?>
<div class="container mt-2">
<h1 class="mt-4 text-center">Add Category</h1>
<div class="d-flex justify-content-center align-items-center my-4">
      <div class="col-md-6">
      <div class="card p-3">
            
                <div class="row">
                    
                        <form method="post" class="form-group">  
                            <label for="name" class="mb-2">Name:</label>
                            <input type="text" name="name" class="form-control">
                            <button type="submit" name="submit" class="btn mt-3" id='thebutton'>Submit</button>
                        </form>
                      
                </div>
           
        </div>
      </div>
    </div>
</div>
<?php ob_end_flush()?>
<?php include('includes/footer.php')?>





