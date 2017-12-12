<?php
require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");

$servername = "/* DBHOST */";
$username = "/* DBUSER */";
$password = "/* DBPASS */";

$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE ojek_cheetos";
if ($conn->query($sql) === TRUE) {
} else {
    echo "Error creating database: " . $conn->error;
    exit();
}

$conn->close();

try {
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if($pdo!=null){
    $query = file_get_contents("database.sql");
    if($pdo->query($query)){
    	echo "Database created successfully";
    } else {
    	echo "Error creating database";
    }
  }
  Database::disconnect();
} catch(PDOException $ex){
  echo $ex->getMessage();
}
?>