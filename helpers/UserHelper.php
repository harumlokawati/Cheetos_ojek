<?php
require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
class UserHelper{
  private static $pdo = null;
  private static $user = array();

  public function __construct() {
  }

  public static function getUser($ID){
  	try {
	    self::$pdo = Database::connect();
	    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    if(self::$pdo!=null){
          Database::disconnect();
	        return self::getUserFromDatabase($ID);
	    }
	  } catch(PDOException $ex){
	    echo $ex->getMessage();
	  }
	  return null;
  }
  
  private static function getUserFromDatabase($ID){
    $query = "SELECT * FROM users WHERE ID = ?";
    $stmt = self::$pdo->prepare($query);
    $stmt->execute(array($ID));
    if($row = $stmt->fetch()){
        foreach ($row as $key => $value) {
            if($key === 'password') continue;
            self::$user[$key] = $value;
        }
    }
    return self::$user;
  }

  public static function getID(){
    return self::$user['ID'];
  }

  public static function getUsername(){
    return self::$user['username'];
  }

  public static function getName(){
    return self::$user['name'];
  }

  public static function getPhone(){
    return self::$user['phone'];
  }

  public static function getEmail(){
    return self::$user['email'];
  }

  public static function getPicUrl(){
    return self::$user['profile_pic_url'];
  }

  public static function getDriver(){
    return self::$user['driver'];
  }

  // public static function getRating(){
  //   return self::$user['rating'];
  // }

  public static function getVotes(){
    return self::$user['votes'];
  }

  public static function setName($new_name){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "UPDATE users SET name = ? WHERE ID = ?";
        $stmt = self::$pdo->prepare($query);
        $ex = $stmt->execute(array($new_name,self::$user['ID']));
        if($ex){
          self::$user['name'] = $new_name;
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function setPhone($new_phone){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "UPDATE users SET phone = ? WHERE ID = ?";
        $stmt = self::$pdo->prepare($query);
        if($stmt->execute(array($new_phone,self::$user['ID']))){
          self::$user['phone'] = $new_phone;
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function setDriver($new_driver){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "UPDATE users SET driver = ? WHERE ID = ?";
        $stmt = self::$pdo->prepare($query);
        if($stmt->execute(array($new_driver,self::$user['ID']))){
          self::$user['driver'] = $new_driver;
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function setPicUrl($new_pic_url){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "UPDATE users SET profile_pic_url = ? WHERE ID = ?";
        $stmt = self::$pdo->prepare($query);
        if($stmt->execute(array($new_pic_url,self::$user['ID']))){
          self::$user['profile_pic_url'] = $new_pic_url;
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }


    // require 'dbconn.php';
    // $id = null;
    // $location = null;
    // $pref = null;
    // if(isset($_POST['id']) && isset($_POST['loc']) && isset($_POST['pref'])){
    //     $id = $_POST['id'];
    //     $location = $_POST['loc'];
    //     $pref = $_POST['pref'];
    //     $pdo = Database::connect();
    //     $get_loc_id = "SELECT ID from locations WHERE location='".$location."'";
    //     $data = $pdo->query($get_loc_id);
    //     foreach($data as $row){
    //         $loc_id = $row['ID'];
    //     }

    //     $exist = false;
    //     $preferred_location = "SELECT location_id FROM user_location WHERE user_id=".$id;
    //     $data = $pdo->query($preferred_location);
    //     foreach($data as $row){
    //         if($row['location_id'] == $loc_id){
    //             $exist = true;
    //             break;
    //         }
    //     }

    //     if(!$exist){
    //         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //         $sql = "INSERT INTO user_location (user_id, location_id, preference_number) VALUES (?, ?, ?)";
    //         $q = $pdo->prepare($sql);
    //         $q->execute(array($id, $loc_id, $pref));
            
    //         echo true;
    //     } else {
    //         echo false;
    //     }
    // }

  public static function addPreferredLocation($new_loc){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "SELECT * FROM locations WHERE location = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute(array($new_loc));
        if(!$row = $stmt->fetch()){
          $query = "INSERT INTO locations (location) VALUES (?)";
          $stmt = self::$pdo->prepare($query);
          if(!$stmt->execute(array($new_loc))){
            return false;
          }
          $id_loc = self::$pdo->lastInsertId();
        } else {
          $id_loc = $row['ID'];
          $query = "SELECT * FROM user_location WHERE location_id = ? AND user_id = ?";
          $stmt = self::$pdo->prepare($query);
          $stmt->execute(array($id_loc,self::$user['ID']));
          if($row = $stmt->fetch()){
            return $new_loc." already exists";
          }
        }
        $query = "INSERT INTO user_location(user_id, location_id, preference_number) VALUES (?,?,?)";
        $stmt = self::$pdo->prepare($query);
        $last_pref_loc = self::getLastPreferredLocation();
        if($stmt->execute(array(self::$user['ID'], $id_loc, $last_pref_loc+1))){
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function getPreferredLocation($id_loc){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "SELECT * FROM user_location WHERE user_location.user_id= ? AND user_location.location_id = ?";
        $stmt = self::$pdo->prepare($query);
        if ($stmt->execute(array(self::$user['ID'],$id_loc))) {
          return $stmt->fetch();
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function getAllPreferredLocation(){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "SELECT * FROM locations JOIN user_location ON locations.ID=user_location.location_id WHERE user_location.user_id= ? ORDER BY user_location.preference_number ASC";
        $stmt = self::$pdo->prepare($query);
        if ($stmt->execute(array(self::$user['ID']))) {
          return $stmt->fetchAll();
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  private static function getLastPreferredLocation(){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "SELECT COUNT(*) as 'total' FROM user_location WHERE user_id = ?";
        $stmt = self::$pdo->prepare($query);
        if($stmt->execute(array(self::$user['ID']))){
          $row = $stmt->fetch();
          return $row['total'];
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return -1;
  }

  public static function delPreferredLocation($loc_id){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "SELECT preference_number FROM user_location WHERE user_id = ? AND location_id = ?;";
        $stmt = self::$pdo->prepare($query);
        if (!$stmt->execute(array(self::$user['ID'],$loc_id))) {
          return false;
        }
        $start = $stmt->fetch()['preference_number'];
        $query = "DELETE FROM user_location WHERE user_id = ? AND location_id = ?;";
        $stmt = self::$pdo->prepare($query);
        echo $query;
        if ($stmt->execute(array(self::$user['ID'],$loc_id))) {
          self::updateAllPreferenceLocation($start,0,count(self::getAllPreferredLocation()));
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }
  public static function updateAllPreferenceLocation($start, $num, $end){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "SELECT location_id, preference_number FROM user_location WHERE user_id = ? ORDER BY user_location.preference_number ASC;";
        $stmt = self::$pdo->prepare($query);
        $locations = array();
        if ($stmt->execute(array(self::$user['ID']))) {
          $i=1;
          // echo "GESER:";
          while($row = $stmt->fetch()){
            if($i>=$start){
              // echo $i;
              $locations[$row['preference_number']] = $row['location_id'];
            }
            $i++;
            if($i>$end) break;
          }
        }
        foreach ($locations as $pref => $loc_id){
          $query = "UPDATE user_location SET preference_number=? WHERE user_id = ? AND location_id = ?;";
          $stmt = self::$pdo->prepare($query);
          if (!$stmt->execute(array($start+$num,self::$user['ID'],$loc_id))) {
            return false;
          }
          $start++;
        }
        return true;
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function editPreferenceLocation($old, $new, $loc_name){
    if($old<$new){
      // move $old -1 $new
      self::updateAllPreferenceLocation($old,-1,$new);
      // update pref $loc_name = $new
    } else {
      // move $new 1 $old
      self::updateAllPreferenceLocation($new,1,$old);
      // update pref $loc_name = $new
    }

    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "UPDATE user_location SET preference_number=? WHERE location_id IN (SELECT l.ID FROM locations as l WHERE l.location=?)";
        $stmt = self::$pdo->prepare($query);
        if($stmt->execute(array($new,$loc_name))){
          echo "UPDATE".$new;
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function setVotes($new_votes){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "UPDATE users SET votes = ? WHERE ID = ?";
        $stmt = self::$pdo->prepare($query);
        if($stmt->execute(array($new_votes,self::$user['ID']))){
          self::$user['votes'] = $new_votes;
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function setRating($new_rating){
    try {
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "UPDATE users SET rating = ? WHERE ID = ?";
        $stmt = self::$pdo->prepare($query);
        if($stmt->execute(array($new_rating,self::$user['ID']))){
          self::$user['rating'] = $new_rating;
          return true;
        }
      }
      Database::disconnect();
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }

  public static function getRating(){
    try{
      self::$pdo = Database::connect();
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(self::$pdo!=null){
        $query = "SELECT SUM(rate) as total_rate, COUNT(rate) as count_rate FROM orders WHERE driver_id = ?";
        $stmt = self::$pdo->prepare($query); 
        $stmt->execute(array(self::$user['ID']));
        $total = 0;
        $count = 0;
        if($row = $stmt->fetch()){
            foreach ($row as $key => $value) {
                if($key == 'total_rate'){
                  $total = $value;
                } else if ($key == 'count_rate'){
                  $count = $value;
                }
            }
            if($count > 0){
              self::$user['rating'] = round($total/$count, 1);
            } else {
              self::$user['rating'] = 0;
            }
            self::$user['votes'] = $count;
            self::setRating(self::$user['rating']);
            self::setVotes(self::$user['votes']);
            return self::$user['rating'];
        } else {
          return 0;
        }
      } else {
        return 0;
      }
    } catch(PDOException $ex){
      echo $ex->getMessage();
    }
    return false;
  }
}
?>