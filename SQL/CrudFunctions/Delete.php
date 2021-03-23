<?php 
    require ("../Functions.php");
    $noteId = -1;
    foreach($_POST as $key => $value){
        if($key == "Note"){
            $noteId = $value;
            break;
        }
    }
    if($noteId == -1){
        header("location: ../../Notes.php?error=9");
    }
    $card = cardFromId($noteId);

    try{
        $conn = openConnection();

        $query = $conn->prepare("SELECT * FROM notes WHERE id=:id");
        $query->bindParam(":id", $noteId);
        $query->execute();
        $result = $query->fetchAll();
        $tasks = explode(",", $result[0]['tasks']);
        echo var_dump($tasks);

        foreach($tasks as $taskId){
            $query = $conn->prepare("DELETE FROM tasks WHERE taskId=:id");
            $query->bindParam(":id", $taskId);
            $query->execute();
        }

        $query = $conn->prepare("DELETE FROM notes WHERE id=:id");
        $query->bindParam(":id", $noteId);
        $query->execute();

        header("location: ../../Notes.php");
    }
    catch(PDOException $e){
        echo "Connection throttled: " . $e->getMessage();
    }