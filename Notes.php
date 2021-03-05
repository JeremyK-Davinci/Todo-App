<?php include ("Includes/Header.php");?>
<?php 
    $cards = cardsFromUser();
?>
    <a href="#" class="btn btn-outline-light font-weight-bold align-self-end offset-11 mt-4" id="newNoteButton"><i class="fas fa-plus"></i> Add</a>
    <div class="container text-left col-12 d-inline-flex mb-2">
        <div class="col-10 d-inline-flex">
            <?php if($cards != NULL){?>
                <?php foreach($cards as $card){?>
                    <?php $tasks = []; $taskIds = explode(",", $card['tasks']);?>
                    <?php foreach($taskIds as $task){?>
                        <?php 
                            $taskId = intval($task);
                            ConsoleLog($taskId);
                            ConsoleLog(tasksFromId($taskId));
                            array_push($tasks, tasksFromId($taskId));
                        ?>
                    <?php }?>
                    <div class="Note col-lg-3 col-sm-6 col-12 d-block mb-5 ml-2 border border-light rounded">
                        <div class="Note-Header col-12 text-left">
                            <h2 class="text-light"><?= $card['title']?></h2>
                        </div>
                        <div class="Note-Body col-12 text-left pb-2">
                            <ul class="ml-3 w-100">
                                <?php foreach($tasks as $task){?>
                                    <li class="text-light font-weight-bold text-decoration-none">
                                        <?php if($task['taskComplete'] == "0"){?>
                                            <p class="font-weight-bold text-info text-decoration-none"><?= $task['taskName']?></p>
                                        <?php } else {?>
                                            <p class="font-weight-bold text-success text-decoration-none"><?= $task['taskName']?></p>
                                        <?php }?>
                                    </li>
                                <?php }?>
                            </ul>
                        </div>
                        <div class="Note-Footer col-12 text-right">
                            <a href="CRUD/Edit.php?id=<?=$card['id']?>" class="btn btn-outline-light font-weight-bold mb-2"><i class="far fa-edit"></i> Edit</a>
                            <a href="#" class="btn btn-outline-danger font-weight-bold mb-2"><i class="fas fa-ban"></i> Remove</a>
                        </div>
                    </div>
                <?php }?>
            <?php } else {?>
                <h1 class="text-center text-white">No cards available</h1>
            <?php }?>
        </div>
    </div>
<?php include ("Includes/Footer.php");?>

<?php 
    setPageTitle("Notes", ob_get_contents());
?>