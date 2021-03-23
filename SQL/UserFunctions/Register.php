<?php
    require ("../Functions.php");
    session_start();
    $username = $_POST['registerName'];
    $mail = $_POST['registerMail'];
    $password = $_POST['registerPass'];
    $passwordConfirm = $_POST['registerPassConfirm'];

    if(empty(trim($username))){
        header("location: ../../Users/Register.php?error=4");
        return;
    }
    if(empty(trim($mail))){
        header("location: ../../Users/Register.php?error=5");
        return;

    }
    if(md5($password) !== md5($passwordConfirm)){
        header("location: ../../Users/Register.php?error=6");
        return;
    }

    sanitize($username);
    sanitize($mail);
    sanitize($password);
    sanitize($passwordConfirm);

    try{
        session_start();

        $conn = openConnection();
        $query = $conn->prepare("SELECT * FROM users WHERE mail=:EM");
        $query->bindParam(":EM", $mail);
        $query->execute();
        $result = $query->fetchAll();
        if(!empty($result)){
            $conn = null;
            header("location: ../../Users/Register.php?error=8");
            return;
        }

        $query = $conn->prepare("SELECT * FROM users WHERE username=:UN");
        $query->bindParam(":UN", $username);
        $query->execute();
        $result = $query->fetchAll();
        if(!empty($result)){
            $conn = null;
            header("location: ../../Users/Register.php?error=7");
            return;
        }

        $query = $conn->prepare("INSERT INTO users (`username`, `password`, `mail`, `trn-date`) VALUES (:UN, :PW, :EM, :TD)");
        $query->bindParam(":UN", $username);
        $query->bindParam(":PW", md5($password));
        $query->bindParam(":EM", $mail);
        $query->bindParam(":TD", date("Y-m-d H:i:s"));
        $query->execute();
        $conn = null;
        header("location: ../../Users/Login.php");
    }
    catch(PDOException $e){
        echo "Connection throttled: " . $e->getMessage();
    }