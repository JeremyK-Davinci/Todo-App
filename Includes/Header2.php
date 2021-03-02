<?php 
    require ("../SQL/UserFunctions.php");
    session_start();
    ob_start();
    $User = UserDetails();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/06ea314d81.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title><!--Title--></title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle Nav">
        <i class="fas fa-lg fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse nav" id="navbarCollapse">
        <ul class="w-100 p-1 m-lg-0 mt-3 mb-0">
            <li class="d-inline pt-lg-5 pr-lg-5 pt-2 pr-2"><a class="text-white h5" href="../Index.php">Home</a></li>
            <?php if(isset($_SESSION['loggedIn'])){?>
                <li class="d-inline pt-lg-5 pr-lg-5 pt-2 pr-2"><a class="text-white h5" href="../Notes.php">Notes</a></li>
                <li class="d-inline float-right pr-lg-1 pr-2"><a class="text-white h5" href="Logout.php"><i class="fas fa-sign-out-alt"></i></a></li>
                <li class="d-inline float-right pr-lg-3 pr-4"><a class="text-white h5" href="Dashboard.php"><i class="fas fa-user"></i></a></li>
            <?php } else{?>
                <li class="d-inline float-right pr-lg-1 pr-2"><a class="text-white h5" href="Register.php"><i class="fas fa-user-plus"></i></a></li>
                <li class="d-inline float-right pr-lg-3 pr-2"><a class="text-white h5" href="Login.php"><i class="fas fa-sign-in-alt"></i></a></li>
            <?php }?>
        </ul>
    </div>
    </nav>