<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/helpers/UserHelper.php");
    $destination = null;
    $pickingpoint = null;
    $preferreddriver = null;
    if(isset($_POST['dest']) && isset($_POST['loc']) && isset($_POST['pref'])){
        $destination = $_POST['dest'];
        $pickingpoint = $_POST['loc'];
        $preferreddriver = $_POST['pref'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = array();
        $qlocation= "SELECT ID FROM locations WHERE location='".$pickingpoint."' LIMIT 1";
        $rows = $pdo->query($qlocation);
        $pickingpointid = null;
        foreach($rows as $row){
            $pickingpointid = $row['ID'];
        }
        if(isset($pickingpointid)){
            $drivers = "SELECT users.ID FROM user_location JOIN users ON users.ID=user_location.user_id WHERE location_id='".$pickingpointid."' AND driver=1 AND NOT users.ID=".$_GET['id_active']." ORDER BY preference_number";
            if($preferreddriver){
                $drivers = "SELECT users.ID FROM user_location JOIN users ON users.ID=user_location.user_id WHERE location_id='".$pickingpointid."' AND driver=1 AND NOT users.name LIKE '%".$preferreddriver."%' AND NOT users.ID=".$_GET['id_active']." ORDER BY preference_number";
            }
            $data = $pdo->query($drivers);
            $i = 0;
            $result = array();
            foreach($data as $row){
                $user = UserHelper::getUser($row['ID']);
                $user['rating'] = round(UserHelper::getRating(), 1);
                $user['votes'] = UserHelper::getVotes();
                array_push($result, $user);
            }
            echo json_encode($result);
        } else {
            echo json_encode(['answer' => 'no data']);
        }
    }else{
        echo false;
    }

?>
