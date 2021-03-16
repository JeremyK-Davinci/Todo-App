<?php include ("../Includes/Header2.php");?>
<?php

    if(!isset($_SESSION['loggedIn'])){
        header("location: ../Index.php");
    }
?>

    <form action="../SQL/CrudFunctions.php" method="post">
        <div class="container text-center col-lg-4 col-sm-8 col-12 offset-sm-2 offset-lg-4 mt-5 mb-2">
            <div class="text-center col-12 mb-5">
                <h2 class="text-light" id="HeaderText">New Note</h2>
            </div>
            <div class="container col-12 border border-light rounded">
                <div class="d-flex offset-1 mt-3">
                    <div class="col-4 mb-3">
                        <h2 class="text-light text-left">Name : </h2>
                    </div>
                    <div class="col-8 mb-3">
                        <input type="text" name="NoteName" class="form-control" placeholder="note name">
                    </div>
                </div>
                <div class="col-11 offset-1 mt-4" id="TaskContainer">
                    
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-outline-light rounded text-center mb-3" id="RemoveTask">-</button>
                    <button type="button" class="btn btn-outline-light rounded text-center mb-3" id="AddTask2">+</button>
                </div>
                <button type="submit" class="btn btn-outline-success rounded text-center mb-3 col-6" name="Create" value="Create">Create Note</button>
            </div>
        </div>
    </form>

    <script src="../JS/index.js"></script>
    <script>addTask2()</script>
<?php include ("../Includes/Footer.php");?>

<?php
    setPageTitle("Add", ob_get_contents());
?>