<?php
    require ("../Functions.php");
    $noteId = -1;
    $values = [];
    foreach($_POST as $key => $value){
        if($key == "EditAddTasks") continue;
        if($key == "Note"){
            $noteId = $value;
            continue;
        }
        array_push($values, $value);
    }
    if($noteId == -1){
        header("location: ../../Notes.php?error=9");
    }
    $card = cardFromId($noteId);
    foreach($values as $newTask){
        try{
            $conn = openConnection();

            $query = $conn->prepare("INSERT INTO tasks (taskName, taskComplete) VALUES (:taskname, 0)");
            $query->bindParam(":taskname", sanitize($newTask));
            $query->execute();
            $lastTaskId = $conn->lastInsertId();

            $query = $conn->prepare("SELECT * FROM notes WHERE id=:id");
            $query->bindParam(":id", $noteId);
            $query->execute();
            $result = $query->fetchAll();
            $currentTasks = $result[0]['tasks'];
            $currentTasks = $currentTasks . ", " . $lastTaskId;

            $query = $conn->prepare("UPDATE notes SET tasks=:tasks WHERE id=:noteid");
            $query->bindParam(":tasks", $currentTasks);
            $query->bindParam(":noteid", $noteId);
            $query->execute();
        }
        catch(PDOException $e){
            echo "Connection throttled: " . $e->getMessage();
        }
    }
    header("location: ../../CRUD/Edit.php?id=" . $noteId);