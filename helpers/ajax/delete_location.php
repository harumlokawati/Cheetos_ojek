<?php
		require_once($_SERVER['DOCUMENT_ROOT']."/helpers/UserHelper.php");
		require_once($_SERVER['DOCUMENT_ROOT']."/helpers/LocationHelper.php");
    $loc = $_POST['loc'];
    $ID = $_POST['id'];
    UserHelper::getUser($ID);
    LocationHelper::getLocationByName($loc);
    $status = UserHelper::delPreferredLocation(LocationHelper::getID());
    echo $status;
?>