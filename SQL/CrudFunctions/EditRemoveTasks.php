<?php
    require ("../Functions.php");
    $noteId = -1;
    $values = [];
    foreach($_POST as $key => $value){
        if($key == "EditRemoveTasks") continue;
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
    foreach($values as $task){
        try{
            $conn = openConnection();

            $query = $conn->prepare("DELETE FROM tasks WHERE taskId=:id");
            $query->bindParam(":id", $task);
            $query->execute();

            $taskList = explode(",", $card[0]['tasks']);
            $newTaskList = [];
            foreach($taskList as $item){
                if(strval($item) == strval($task)) continue;
                array_push($newTaskList, $item);
            }
            $tasks = implode($newTaskList, ",");

            $query = $conn->prepare("UPDATE notes SET tasks=:tasks WHERE id=:noteid");
            $query->bindParam(":tasks", $tasks);
            $query->bindParam(":noteid", $noteId);
            $query->execute();
        }
        catch(PDOException $e){
            echo "Connection throttled: " . $e->getMessage();
        }
    }
    header("location: ../../CRUD/Edit.php?id=" . $noteId);