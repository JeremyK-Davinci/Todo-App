<?php include ("Includes/Header.php");?>
    <div class="container text-center col-10 d-inline-flex offset-1 mt-5 mb-2">
        <h1 class="text-white text-center col-12" id="HeaderText">Todo App</h1>
    </div>
<?php include ("Includes/Footer.php");?>

<?php 
    setPageTitle("Home", ob_get_contents());
?>