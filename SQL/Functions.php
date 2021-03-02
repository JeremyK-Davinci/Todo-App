<?php 
    require ("Connector.php");
    session_start();

    function setPageTitle($title, $contents){
        ob_end_clean();
        echo str_replace('<!--Title-->', $title, $contents);
    }

    function UserDetails(){
        $conn = openConnection();
        $query = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $query->bindParam(":id", $_SESSION['userId']);
        $query->execute();
        $conn = NULL;
        return $query->fetchAll();
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
        }
    }