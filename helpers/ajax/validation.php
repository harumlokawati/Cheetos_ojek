<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    $email = null;
    $username = null;
    if(isset($_GET['email'])) $email = $_GET["email"];
    if(isset($_GET['username'])) $username = $_GET["username"];
    $pdo = null;
    try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($pdo!=null){
            run();
        }
    } catch(PDOException $ex){
        echo $ex->getMessage();
    }
    
    function run(){
        global $username, $email, $pdo;
        if($email){
            $query = "SELECT * FROM users WHERE email = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array($email));
            if (!$row = $stmt->fetch()){
                echo "available";
            } else {
                echo "data exist";
            }
        }

        if($username){
            $query = "SELECT * FROM users where username = ?";
            $stmt = $pdo->prepare($query);
            $stmt->execute(array($username));
            if (!$row = $stmt->fetch()){
                echo "available";
            } else {
                echo "data exist";
            }
        }
    }

    Database::disconnect();
?>