<?php include ("../Includes/Header2.php");?>
<?php 
    if(!isset($_SESSION['loggedIn'])){
        header("location: ../Index.php");
    }

    $noteId = $_GET['id'];
    $note = cardFromId($noteId);
    if($note == null){
        header("location: ../Notes.php");
    }

    $tasks = $note[0]['tasks'];
    $tasklist = explode(',', $tasks);
?>
    <form action="../SQL/Functions.php" method="post">
        <div class="container text-center col-10 offset-1 mt-5 mb-2">
            <h1 class="text-white text-center col-12" id="HeaderText">Editing Task : <?= $note[0]['title']?></h1>
            <div class="container col-12 mt-5 mb-2">
                <?php foreach($tasklist as $taskId){?>
                    <?php $task = tasksFromId($taskId);?>
                    
                <?php }?>
            </div>
        </div>
    </form>
<?php include ("../Includes/Footer.php");?>

<?php
    setPageTitle("Edit", ob_get_contents());
?>