<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
        <i class="fas fa-gem me-3"></i><span c>Cafeteria</span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav  mx-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="../user/userhome.php">Home</a>
                    </li>  
                    <li class="nav-item">
                    <a class="nav-link" href="../user/user-orders.php">My Orders</a>
                    </li>
                </ul>
                <div class="user-info" style="margin-left:600px;">
                <div class="d-flex align-items-center">
                <?php
                echo "<img class='img-fluid' src='../assests/images/$image' alt='$username' title='$username' width='60' height='60'/>";
				echo "<p class='mt-3 mx-2'>$username</p>";
                ?>
                </div>
          
        </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
