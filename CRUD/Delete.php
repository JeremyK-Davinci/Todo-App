<?php include ("../Includes/Header2.php");?>
<?php 
    if(!isset($_SESSION['loggedIn'])){
        header("location: ../Index.php");
    }
    $noteId = $_GET['id'];
    $note = cardFromId($noteId);
    if($note == null || strval($_SESSION['userId']) != strval($note[0]['userId'])){
        header("location: ../Notes.php?error=10");
    }

    $tasks = $note[0]['tasks'];
    $tasklist = explode(',', $tasks);
?>

<form action="../SQL/CrudFunctions/Delete.php" method="post">
    <div class="container text-center col-10 offset-1 mt-5 mb-2">
        <h1 class="text-white text-center col-12" id="HeaderText">Are you sure you want to delete : <?= $note[0]['title']?></h1>
        <div class="container col-12 justify-content-center mt-5 mb-2 d-inline-flex">
            <input type="hidden" name="Note" value=<?=$noteId?>>
            <div class="Note col-lg-4 col-sm-8 col-12 d-block mb-5 ml-2 mr-5 rounded">
                <div class="Note-Header col-12 text-left">
                    <h4 class="text-light">And it's tasks : </h4>
                </div>
                <div class="Note-Body col-12 text-left pb-2">
                    <ul class="w-100 list-group">
                        <?php foreach($tasklist as $taskId){?>
                            <?php $task = tasksFromId($taskId);?>
                            <?php $taskComplete = $task['taskComplete'] == 0 ? 'incomplete' : 'complete'?>
                            <li class="text-light font-weight-bold text-decoration-none text-center list-group-item">
                                <?php if($taskComplete == 'incomplete'){?>
                                    <p class="font-weight-bold text-info text-decoration-none" data-toggle="tooltip" title=<?= $taskComplete?>><?= $task['taskName']?></p>
                                <?php } else {?>
                                    <p class="font-weight-bold text-success text-decoration-none" data-toggle="tooltip" title=<?= $taskComplete?>><?= $task['taskName']?></p>
                                <?php }?>
                            </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="Note-Footer col-12 text-center mt-2">
                    <button type="submit" class="btn btn-outline-danger rounded col-5 mb-2" name="Delete" value="Delete">Yes</button>
                    <a href="../Notes.php" class="btn btn-outline-success rounded col-5 offset-1 mb-2">No</a>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include ("../Includes/Footer.php");?>

<?php 
    setPageTitle("Delete", ob_get_contents());
?>