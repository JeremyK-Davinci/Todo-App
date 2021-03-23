<?php
    require ("../Functions.php");
    session_start();
    $noteName = "";
    $taskNames = [];
    $taskIds = [];
    foreach($_POST as $key => $value){
        if($key == "Create") continue;
        if($key == "NoteName"){
            $noteName = $value;
            continue;
        }
        array_push($taskNames, $value);
    }

    if(empty(trim($noteName))){
        header("location: ../../Notes.php?error=11");
    }

    $conn = openConnection();

    try{
        foreach($taskNames as $name){
            $query = $conn->prepare("INSERT INTO tasks (taskName, taskComplete) VALUES (:taskname, 0)");
            $query->bindParam(":taskname", sanitize($name));
            $query->execute();
            $lastTaskId = $conn->lastInsertId();
            array_push($taskIds, $lastTaskId);
        }

        $taskIdString = implode(", ", $taskIds);
        $query = $conn->prepare("INSERT INTO notes (title, tasks, userId) VALUES (:notename, :tasks, :user)");
        $query->bindParam(":notename", $noteName);
        $query->bindParam(":tasks", $taskIdString);
        $query->bindParam(":user", $_SESSION['userId']);
        $query->execute();

        header("location: ../../Notes.php");
    }
    catch(PDOException $e){
        echo "Connection throttled: " . $e->getMessage();
    }