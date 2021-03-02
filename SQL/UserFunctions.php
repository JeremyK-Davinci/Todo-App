<?php
    require ("Functions.php");
    session_start();

    function attemptLogin(){
        $username = sanitize($_POST['loginName']);
        $password = sanitize($_POST['loginPass']);

        if(empty(trim($username))){
            header("location: ../Users/Login.php?error=1");
        }
        if(empty(trim($password))){
            header("location: ../Users/Login.php?error=2");
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
                header("location: ../Index.php");
            }
            else{
                $conn = null;
                header("location: ../Users/Login.php?error=3");
            }
            return $result;
        }
        catch(PDOException $e){
            echo "Connection throttled: " . $e->getMessage();
        }
    }

    function attemptRegistration(){
        $username = sanitize($_POST['registerName']);
        $mail = sanitize($_POST['registerMail']);
        $password = sanitize($_POST['registerPass']);
        $passwordConfirm = sanitize($_POST['registerPassConfirm']);

        if(empty(trim($username))){
            header("location: ../Users/Login.php?error=4");
        }
        if(empty(trim($mail))){
            header("location: ../Users/Login.php?error=5");
        }
        if($password != $passwordConfirm){
            header("location: ../Users/Login.php?error=6");
        }

        try{
            session_start();

            $conn = openConnection();
            $query = $conn->prepare("SELECT * FROM users WHERE mail=:EM");
            $query->bindParam(":EM", $mail);
            $query->execute();
            $result = $query->fetchAll();
            if(!empty($result)){
                $conn = null;
                header("location: ../Users/Register.php?error=8");
                return;
            }

            $query = $conn->prepare("SELECT * FROM users WHERE username=:UN");
            $query->bindParam(":UN", $username);
            $query->execute();
            $result = $query->fetchAll();
            if(!empty($result)){
                $conn = null;
                header("location: ../Users/Register.php?error=7");
                return;
            }

            $query = $conn->prepare("INSERT INTO users (`username`, `password`, `mail`, `trn-date`) VALUES (:UN, :PW, :EM, :TD)");
            $query->bindParam(":UN", $username);
            $query->bindParam(":PW", md5($password));
            $query->bindParam(":EM", $mail);
            $query->bindParam(":TD", date("Y-m-d H:i:s"));
            $query->execute();
            $conn = null;
            header("location: ../Users/Login.php");
        }
        catch(PDOException $e){
            echo "Connection throttled: " . $e->getMessage();
        }
    }

    if(isset($_POST['login'])){
        attemptLogin();
    }

    if(isset($_POST['register'])){
        attemptRegistration();
    }