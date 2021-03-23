<?php include ("../Includes/Header2.php");?>
<?php 
    if(isset($_SESSION['loggedIn'])){
        header("location: ../Index.php");
    }

    $errorId = $_GET['error'];
    $error = getErrorMessageFromId($errorId);
?>

<div class="form-container border border-dark rounded col-8 col-md-6 col-lg-2 offset-2 offset-md-3 offset-lg-5">
    <h1 class="text-white text-center">Register</h1>
    <form action="../SQL/UserFunctions/Register.php" method="post" name="register" autocomplete="off">

        <?php if(!empty($error) && $errorId == 4 || $errorId == 7){?>
            <div class="form-group text-left text-white">
                <label for="registerName">Username</label>
                <input class="form-control border-danger" data-toggle="tooltip" title="<?=$error?>" type="text" name="registerName" required>
            </div>
        <?php } else {?>
            <div class="form-group text-left text-white">
                <label for="registerName">Username</label>
                <input class="form-control" type="text" name="registerName" required>
            </div>
        <?php }?>

        <?php if(!empty($error) && $errorId == 5 || $errorId == 8){?>
            <div class="form-group text-left text-white">
                <label for="registerMail">E-mail</label>
                <input class="form-control border-danger" data-toggle="tooltip" title="<?=$error?>" type="text" name="registerMail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
            </div>
        <?php } else {?>
            <div class="form-group text-left text-white">
                <label for="registerMail">E-mail</label>
                <input class="form-control" type="text" name="registerMail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
            </div>
        <?php }?>

        <?php if(!empty($error) && $errorId == 6){?>
            <div class="form-group text-left text-white">
                <label for="registerPass">Password</label>
                <input class="form-control border-danger" data-toggle="tooltip" title="<?=$error?>" type="password" name="registerPass" pattern=".{8,}" required>
            </div> 
        <?php } else {?>
            <div class="form-group text-left text-white">
                <label for="registerPass">Password</label>
                <input class="form-control" type="password" name="registerPass" pattern=".{8,}" required>
            </div> 
        <?php }?>

        <div class="form-group text-left text-white">
            <label for="registerPassConfirm">Confirm Password</label>
            <input class="form-control" type="password" name="registerPassConfirm" pattern=".{8,}" required>
        </div>
        <div class="form-group text-center">
            <input class="form-submit col-8 col-lg-6 rounded" type="submit" name="register" value="Register">
        </div>
    </form>
</div>

<?php include ("../Includes/Footer.php");?>

<?php
    setPageTitle("Register", ob_get_contents());
?>