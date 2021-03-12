<?php
    require ("Functions.php");
    session_start();

    function attemptEdit(){
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
            header("location: ../Notes.php?error=9");
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
                $query = $conn->prepare("UPDATE tasks SET taskComplete=:finished WHERE taskId=:id");
                $query->bindParam(":id", $id);
                $query->bindParam(":finished", isTaskComplete($values, $index));
                $query->execute();
                $conn = null;
                $index++;
            }
            catch(PDOException $e){
                echo "Connection throttled: " . $e->getMessage();
            }
        }

        header("location: ../Notes.php");
    }

    function attemptEditAddTasks(){
        $noteId = -1;
        $keys = [];
        $values = [];
        foreach($_POST as $key => $value){
            if($key == "EditAddTasks") continue;
            if($key == "Note"){
                $noteId = $value;
                continue;
            }
            array_push($keys, str_replace("_", " ", $key));
            array_push($values, $value);
        }
        if($noteId == -1){
            header("location: ../Notes.php?error=9");
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
        header("location: ../CRUD/Edit.php?id=" . $noteId);
    }

    function attemptEditRemoveTasks(){
        $noteId = -1;
        $keys = [];
        $values = [];
        foreach($_POST as $key => $value){
            if($key == "EditRemoveTasks") continue;
            if($key == "Note"){
                $noteId = $value;
                continue;
            }
            array_push($keys, str_replace("_", " ", $key));
            array_push($values, $value);
        }

        if($noteId == -1){
            header("location: ../Notes.php?error=9");
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
        header("location: ../CRUD/Edit.php?id=" . $noteId);
    }

    function attemptDeleteNote(){
        $noteId = -1;
        foreach($_POST as $key => $value){
            if($key == "Note"){
                $noteId = $value;
                break;
            }
        }
        if($noteId == -1){
            header("location: ../Notes.php?error=9");
        }
        $card = cardFromId($noteId);

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

        header("location: ../Notes.php");
    }



    if(isset($_POST['Edit'])){
        attemptEdit();
    }

    if(isset($_POST['EditAddTasks'])){
        attemptEditAddTasks();
    }

    if(isset($_POST['EditRemoveTasks'])){
        attemptEditRemoveTasks();
    }

    if(isset($_POST['Delete'])){
        attemptDeleteNote();
    }



    function isTaskComplete($array, $index){
        if(strtolower($array[$index]) == "true" || strtolower($array[$index]) == "complete") return 1;
        else if(strtolower($array[$index]) == "false" || strtolower($array[$index]) == "incomplete") return 0;
        else return 0;
    }