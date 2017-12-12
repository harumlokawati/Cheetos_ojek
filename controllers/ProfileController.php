<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/helpers/UserHelper.php");
  require_once($_SERVER['DOCUMENT_ROOT']."/helpers/LocationHelper.php");
  $has_edited = $_SERVER['REQUEST_METHOD'] === 'POST';
  $status = null;
  $msg = null;

  function upload(){
      global $status;
      if(!empty($_FILES['uploaded_file']['name'])){
        if (!file_exists("uploads")){
            $status = "No folder uploads, please create it!";
            return;
        }
        if (file_exists("uploads/" . $_FILES["uploaded_file"]["name"])){
            $status = $_FILES["uploaded_file"]["name"] . " already exists. ";
            return;
        }
        $path = "uploads/";
        $path = $path . basename( $_FILES['uploaded_file']['name']);
        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
          UserHelper::setPicUrl($path);
        } else{
            $status = "There was an error uploading the file, please try again!";
        }
      }
  }

  if($has_edited){
    $phone = null;
    $is_driver = 0;
    $location = null;
    $page = null;
    $locations= UserHelper::getAllPreferredLocation();
    $location_total = count($locations);

    // foreach ($locations as $key => $value) {
    //   echo $key.$value."<br>";
    // }

    $edited_location = array();
    for($i=1; $i<=$location_total; $i++){
      if(isset($_POST['pref-'.$i])){
        // echo $_POST['pref-'.$i];
        // echo $_POT['loc-'.$i];
        $old_pref = $i;
        $new_pref = $_POST['pref-'.$i];
        // echo $old_pref.$new_pref;
        // UserHelper::updateAllPreferenceLocation($old_pref,-1,$new_pref);
        UserHelper::editPreferenceLocation($old_pref, $new_pref, $_POST['loc-'.$i]);
      }
    }
    if(isset($_POST['name'])) $name = $_POST['name'];
    if(isset($_POST['phone'])) $phone = $_POST['phone'];
    if(isset($_POST['isDriver'])) {
      $is_driver = 1;
    }
    if(isset($_POST['location'])) $location = $_POST['location'];
    if(isset($_GET['edit'])) $page = $_GET['edit'];
    
    if($page=='profile'){
      if($name) UserHelper::setName($name);
      if($phone) UserHelper::setPhone($phone);
      if($is_driver !== UserHelper::getDriver()) UserHelper::setDriver($is_driver);
      upload();
      if(!$status){
          header('Location: '.'/profile.php?id_active='.$ID);
      }
    } else if($page=='location'){
      if($location){
        $msg = UserHelper::addPreferredLocation($location);
      }
    }
  }
?>