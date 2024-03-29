<?php 
    require ("Connector.php");
    session_start();

    function sanitize($data) {
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripcslashes($data);
        return $data;
    }

    function setPageTitle($title, $contents){
        ob_end_clean();
        echo str_replace('<!--Title-->', $title, $contents);
    }

    function ConsoleLog($message, $withScriptTags = true){
        $js = 'console.log('. json_encode($message).');';
        if($withScriptTags){
            $js = '<script>' . $js . '</script>';
        }
        echo $js;
    }

    function getErrorMessageFromId($id){
        switch($id){
            case 1:
                return "Username was blank";
            case 2:
                return "Password was blank";
            case 3:
                return "Wrong password or username";
            case 4:
                return "Username was blank";
            case 5:
                return "E-mail was blank";
            case 6:
                return "Passwords don't match";
            case 7:
                return "Username already exists";
            case 8:
                return "E-mail already exists";
            case 9:
                return "Server recieved incorrect note id and aborted";
            case 10:
                return "The card that was accessed does not belong to you";
            case 11:
                return "Card name cannot be empty";
        }
    }

    function isTaskComplete($array, $index){
        if(strtolower($array[$index]) == "true" || strtolower($array[$index]) == "complete") return 1;
        else if(strtolower($array[$index]) == "false" || strtolower($array[$index]) == "incomplete") return 0;
        else return 0;
    }

    function userDetails(){
        $conn = openConnection();
        $query = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $query->bindParam(":id", $_SESSION['userId']);
        $query->execute();
        $conn = null;
        return $query->fetchAll();
    }

    function cardsFromUser(){
        $conn = openConnection();
        $query = $conn->prepare("SELECT * FROM notes WHERE userId=:id");
        $query->bindParam(":id", $_SESSION['userId']);
        $query->execute();
        $conn = null;
        return $query->fetchAll();
    }

    function cardFromId($id){
        $conn = openConnection();
        $query = $conn->prepare("SELECT * FROM notes WHERE id=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $conn = null;
        return $query->fetchAll();
    }

    function tasksFromId($id){
        $conn = openConnection();
        $query = $conn->prepare("SELECT * FROM tasks WHERE taskId=:id");
        $query->bindParam(":id", $id);
        $query->execute();
        $conn = null;
        return $query->fetchAll()[0];
    }