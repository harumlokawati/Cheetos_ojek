<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    $destination = null;
    $pickingpoint = null;
    $preferreddriver = null;
    if(isset($_POST['dest']) && isset($_POST['loc']) && isset($_POST['pref'])){
        $destination = $_POST['dest'];
        $pickingpoint = $_POST['loc'];
        $preferreddriver = $_POST['pref'];
        $pdo = Database::connect();
        $result = array();
		$qlocation= "SELECT ID FROM locations WHERE location='".$pickingpoint."' LIMIT 1";
        $rows = $pdo->query($qlocation);
        $pickingpointid = null;
        foreach($rows as $row){
            $pickingpointid = $row['ID'];
        }
        if(isset($preferreddriver) && $preferreddriver)
        {
            $get_pref_driver = "SELECT DISTINCT * FROM users JOIN user_location ON users.ID = user_location.user_id WHERE name LIKE '%".$preferreddriver."%' AND driver=1 AND NOT users.ID=".$_GET['id_active']." AND location_id=".$pickingpointid;
            $rows = $pdo->query($get_pref_driver);
            $result = array();
            foreach($rows as $row){
                array_push($result, $row);
            }
            echo json_encode($result);
        }else{
            echo json_encode(['answer' => 'no data']);
        }
    }else{
        echo false;
    }
?>
