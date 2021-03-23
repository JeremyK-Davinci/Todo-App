<?php
    require ("../Functions.php");
    session_start();
    $username = sanitize($_POST['loginName']);
    $password = sanitize($_POST['loginPass']);

    if(empty(trim($username))){
        header("location: ../../Users/Login.php?error=1");
    }
    if(empty(trim($password))){
        header("location: ../../Users/Login.php?error=2");
    }

    try{
        session_start();

        $conn = openConnection();
        $query = $conn->prepare("SELECT * FROM users WHERE username = :UN and password = :PW");
        $query->bindParam(':UN', $username);
        $query->bindParam(':PW', md5($password));
        $query->execute();

        $result = $query->fetchAll();
        if($query->rowCount($result) > 0){
            session_regenerate_id();
            $_SESSION['loggedIn'] = true;
            $_SESSION['userId'] = $result[0]['id'];
            $_SESSION['username'] = $result[0]['username'];
            $_SESSION['password'] = $result[0]['password'];
            session_write_close();
            $conn = null;
            header("location: ../../Index.php");
        }
        else{
            $conn = null;
            header("location: ../../Users/Login.php?error=3");
        }
        return $result;
    }
    catch(PDOException $e){
        echo "Connection throttled: " . $e->getMessage();
    }