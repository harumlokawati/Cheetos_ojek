<?php
require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
class LocationHelper{
  private static $pdo = null;
  private static $location = array();

  public function __construct() {
  }

  public static function getLocation($ID){
  	try {
	    self::$pdo = Database::connect();
	    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    if(self::$pdo!=null){
		    $query = "SELECT * FROM locations WHERE ID = ?";
		    $stmt = self::$pdo->prepare($query);
		    $stmt->execute(array($ID));
		    if($row = $stmt->fetch()){
		        foreach ($row as $key => $value) {
		            self::$location[$key] = $value;
		        }
		    }
		    return self::$location;
	    }
	    Database::disconnect();
	  } catch(PDOException $ex){
	    echo $ex->getMessage();
	  }
	  return null;
  }

   public static function getLocationByName($name){
  	try {
	    self::$pdo = Database::connect();
	    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    if(self::$pdo!=null){
		    $query = "SELECT * FROM locations WHERE location = ?";
		    $stmt = self::$pdo->prepare($query);
		    $stmt->execute(array($name));
		    if($row = $stmt->fetch()){
		        foreach ($row as $key => $value) {
		            self::$location[$key] = $value;
		        }
		    }
		    return self::$location;
	    }
	    Database::disconnect();
	  } catch(PDOException $ex){
	    echo $ex->getMessage();
	  }
	  return null;
  }

  public static function getID(){
    return self::$location['ID'];
  }
}