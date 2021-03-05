<?php
    
    function openConnection(){
        $serverName = "localhost";
        $username = "Admin";
        $password = "CkN21p3m";

        try
        {
            $conn = new PDO("mysql:host=$servername;dbname=todoapp", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }