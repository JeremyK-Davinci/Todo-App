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
    <div id="overlayBackgroundAdd">
        <div class="col-4 text-center border border-light rounded" id="overlayContainer">
            <button type="button" class="btn btn-outline-light rounded toggleOverlay float-right mt-3">Close</button>
            <form action="../SQL/CrudFunctions/EditAddTasks.php" method="post">
                <input type="hidden" name="Note" value=<?=$noteId?>>
                <div class="container text-left col-8 offset-2 bg-dark rounded offset-1 mt-5 pb-2">
                    <h3 class="text-light text-center">New Tasks</h3>
                    <div class="mt-3 mb-2" id="TaskContainer">
                    </div>
                    <button type="button" class="btn btn-outline-light rounded text-center" id="RemoveTask">-</button>
                    <button type="button" class="btn btn-outline-light rounded text-center" id="AddTask">+</button>
                </div>
                <button type="submit" class="btn btn-outline-success rounded col-2 mt-3 mb-3" name="EditAddTasks" value="EditAddTasks">Add Tasks</button>
            </form>
        </div>
    </div>

    <div id="overlayBackgroundRemove">
        <div class="col-4 text-center border border-light rounded" id="overlayContainer2">
            <button type="button" class="btn btn-outline-light rounded toggleOverlayRemove float-right mt-3">Close</button>
            <form action="../SQL/CrudFunctions/EditRemoveTasks.php" method="post">
                <input type="hidden" name="Note" value=<?=$noteId?>>
                <div class="container text-left col-8 offset-2 bg-dark rounded offset-1 mt-5 pb-2">
                    <h3 class="text-light text-center">Tasks</h3>
                    <div class="mt-3 mb-2" id="TaskContainerRemove">
                        <?php foreach($tasklist as $taskId){?>
                            <?php $task = tasksFromId($taskId);?>
                            <div class="d-flex offset-2">
                                <div class="col-8 mb-3">
                                    <h2 class="text-light text-left"><?= $task['taskName']?></h2>
                                </div>
                                <div class="col-4 mt-2">
                                    <input type="checkbox" name="<?= $taskId?>" class="form-check-input CheckRemove" value="<?= $taskId?>">
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-danger rounded col-2 mt-3 mb-3" name="EditRemoveTasks" value="EditRemoveTasks">Remove Tasks</button>
            </form>
        </div>
    </div>

    <form action="../SQL/CrudFunctions/Edit.php" method="post">
        <div class="container text-center col-10 offset-1 mt-5 mb-2">
            <h1 class="text-white text-center col-12" id="HeaderText">Editing task : <?= $note[0]['title']?></h1>
            <div class="container col-12 mt-5 mb-2">
                <input type="hidden" name="Note" value=<?=$noteId?>>
                <?php foreach($tasklist as $taskId){?>
                    <?php $task = tasksFromId($taskId);?>
                    <?php $taskComplete = $task['taskComplete'] == 0 ? 'incomplete' : 'complete'?>
                    <div class="d-flex offset-4">
                        <div class="col-4 mb-3">
                            <input class="form-control text-left" type="text" name="taskName<?=$task['taskId']?>" value="<?= $task['taskName']?>">
                        </div>
                        <div class="col-8 mb-3">
                            <input class="form-control col-3" type="text" name="<?= $task['taskId']?>" value="<?=$taskComplete?>">
                        </div>
                    </div>
                <?php }?>
                <button type="button" class="btn btn-outline-light rounded col-2 ml-4 toggleOverlay">Add Task</button>
                <button type="button" class="btn btn-outline-light rounded col-2 toggleOverlayRemove">Remove Task</button>
                <br>
                <button type="submit" class="btn btn-outline-success rounded col-4 ml-4 mt-2" name="Edit" value="Edit">Edit</button>
            </div>
        </div>
    </form>

    <script src="../JS/index.js"></script>
    <script>addTask()</script>
<?php include ("../Includes/Footer.php");?>

<?php
    setPageTitle("Edit", ob_get_contents());
?>