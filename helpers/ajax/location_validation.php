<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    $destination = null;
    $pickingpoint = null;
	$result= "salah";
    if(isset($_POST['dest']) && isset($_POST['loc'])){
        $destination = $_POST['dest'];
        $pickingpoint = $_POST['loc'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$qdest = "SELECT * FROM locations WHERE location='".$destination."'";
        $qloc= "SELECT * FROM locations WHERE location='".$pickingpoint."'";
        $dests = $pdo->query($qdest);
		$locs = $pdo->query($qloc);
		Database::disconnect();
		$rowdest=0;
		$rowlocs=0;
		foreach($dests as $dest){
			$rowdest++;
		}
		foreach($locs as $loc){
			$rowlocs++;
		}
		if(($rowdest>0)&&($rowlocs>0)){
			$result="bener";
		}
		echo $result;
	}
?>