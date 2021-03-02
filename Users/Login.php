<?php include ("../Includes/Header2.php");?>
<?php 
    if(isset($_SESSION['loggedIn'])){
        header("location: ../Index.php");
    }
    $errorId = $_GET['error'];
    $error = getErrorMessageFromId($errorId);
?>

<div class="form-container border border-dark rounded col-8 col-md-6 col-lg-2 offset-2 offset-md-3 offset-lg-5">
    <h1 class="text-white text-center">Login</h1>
    <form action="../SQL/UserFunctions.php" method="post" name="login" autocomplete="off">

        <?php if(!empty($error) && $errorId == 1){?>
            <div class="form-group text-left text-white">
                <label for="loginName">Username</label>
                <input class="form-control border-danger" data-toggle="tooltip" title="<?=$error?>" type="text" name="loginName" required>
            </div>   
        <?php } else{?>
            <div class="form-group text-left text-white">
                <label for="loginName">Username</label>
                <input class="form-control" type="text" name="loginName" required>
            </div>  
        <?php }?>

        <?php if(!empty($error) && $errorId == 2 || $errorId == 3){?>
            <div class="form-group text-left text-white">
                <label for="loginPass">Password</label>
                <input class="form-control border-danger" data-toggle="tooltip" title="<?=$error?>" type="password" name="loginPass" required>
            </div>   
        <?php } else{?>
            <div class="form-group text-left text-white">
                <label for="loginPass">Password</label>
                <input class="form-control" type="password" name="loginPass" required>
            </div>  
        <?php }?>

        <div class="form-group text-center">
            <input class="form-submit col-8 col-lg-6 rounded" type="submit" name="login" value="Login">
        </div>
    </form>
</div>

<?php include ("../Includes/Footer.php");?>

<?php
    setPageTitle("Login", ob_get_contents());
?>