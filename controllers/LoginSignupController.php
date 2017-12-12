<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
  $status_aborted = FALSE;
  $has_submit = $_SERVER['REQUEST_METHOD'] === 'POST';
  $file = $_SERVER['PHP_SELF'];
  $path = "http://".$_SERVER['HTTP_HOST'];

  function signUp(){
    global $pdo, $username, $email, $status;
    if($username){
      $data = array($username, $email);
      $query = "SELECT * FROM users WHERE username = ? OR email = ?";
      $stmt = $pdo->prepare($query);
      $stmt->execute($data);
      if(!($row = $stmt->fetch())){
        createUser();
      } else {
        $status = "username atau email telah terdaftar sebelumnya";
      }
    }
  }

  function createUser(){
    global $pdo, $username, $email, $fullname, $password, $phone, $is_driver, $status;
    if($username && $email && $fullname && $password && $phone){
      $default_pic = 'http://'.$_SERVER['HTTP_HOST'].'/assets/images/pikachu.png';
      $data = array($username, $password, $fullname,$phone,$email,$default_pic,$is_driver);
      $stmt = $pdo->prepare("INSERT INTO users (username, password, name, phone, email, profile_pic_url, driver) VALUES (?,?,?,?,?,?,?)");
      if($stmt->execute($data)){
        $ID = $pdo->lastInsertId();
        Database::disconnect();
        if($is_driver==1){
          header('Location: '.'/profile.php?id_active='.$ID);
        } else {
          header('Location: '.'/order.php?id_active='.$ID);
        }
      }
    } else {
      foreach ($_POST as $key => $value) {
        if($value==''){
          $status += $key . ', ';
        }
      }
      $status += "tidak boleh kosong";
    }
  }

  function signIn(){
    global $pdo, $username, $password, $status_aborted;
    if($username){
      $data = array($username, $password);
      $query = "SELECT * FROM users WHERE username = ? AND password = ?";
      $stmt = $pdo->prepare($query);
      $stmt->execute($data);
      if($row = $stmt->fetch()){
        $driver = $row['driver'];
        $ID = $row['ID'];
        Database::disconnect();
        if($driver==1){
          header('Location: '.'/profile.php?id_active='.$ID);
        } else {
          header('Location: '.'/order.php?id_active='.$ID);
        }
      } else {
        $status_aborted = TRUE;
      }
    }
  }

  if($has_submit){
      $pdo = null;
      try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if($pdo!=null){
          if(isset($_POST['submit'])){
            if($file == "/login.php"){
              $username = $_POST['username'];
              $password =  $_POST['password'];
              signIn();
            } else {
              $fullname = $_POST['full-name'];
              $username = $_POST['username'];
              $email = $_POST['email'];
              $password =  $_POST['password'];
              $phone =  $_POST['phone'];
              $is_driver = 0;
              if(isset($_POST['isDriver'])){
                $is_driver = 1;
              }
              signUp();
            }
          }
        }
        Database::disconnect();
      } catch(PDOException $ex){
        echo $ex->getMessage();
      }
  }
?>