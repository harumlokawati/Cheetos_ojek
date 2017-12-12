<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    $id_driver =null;
    if(isset($_POST['iddriver'])){
        $id_driver = $_POST['iddriver'];
        $pdo = Database::connect();
        $result = array();
        if(isset($id_driver))
        {
            $get_pref_driver = "SELECT DISTINCT * from users WHERE ID='".$id_driver."'";
            $rows = $pdo->query($get_pref_driver);
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