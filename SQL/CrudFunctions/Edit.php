<?php
    require ("../Functions.php");
    $noteId = -1;
    $keys = [];
    $values = [];
    $tasks = [];
    $index = 0;
    foreach($_POST as $key => $value){
        if($key == "Edit") continue;
        if($key == "Note"){
            $noteId = $value;
            continue;
        }
        array_push($keys, str_replace("_", " ", $key));
        array_push($values, $value);
    }
    if($noteId == -1){
        header("location: ../../Notes.php?error=9");
    }
    $card = cardFromId($noteId);
    $taskList = explode(",", $card[0]['tasks']);
    foreach($taskList as $taskId){
        if(in_array(intval($taskId), $keys)){
            array_push($tasks, $taskId);
        }
    }
    foreach($tasks as $id){
        try{
            $conn = openConnection();
            $query = $conn->prepare("UPDATE tasks SET taskComplete=:finished, taskName=:taskName WHERE taskId=:id");
            $query->bindParam(":id", $id);
            $query->bindParam(":finished", isTaskComplete($values, $index+1));
            $query->bindParam(":taskName", sanitize($values[$index]));
            $query->execute();
            $conn = null;
            $index+=2;
        }
        catch(PDOException $e){
            echo "Connection throttled: " . $e->getMessage();
        }
    }

    header("location: ../../Notes.php");