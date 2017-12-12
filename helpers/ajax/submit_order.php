<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    $destination = null;
    $pickingpoint = null;
    $id_driver = null;
	$id_customer = null;
	$comment = null;
	$rating = null;
    if(isset($_POST['dest']) && isset($_POST['idcust']) && isset($_POST['iddriver'])&&isset($_POST['loc'])&&isset($_POST['comm'])&&isset($_POST['rate'])){
        $destination = $_POST['dest'];
		$pickingpoint = $_POST['loc'];
		$id_driver = $_POST['iddriver'];
		$id_customer = $_POST['idcust'];
		$comment = $_POST['comm'];
		$rating = $_POST['rate'];
        try {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if($pdo!=null){
				$query = "SELECT ID FROM locations WHERE location LIKE '".$destination."'";
				$rows = $pdo->query($query);
				$dest_id = null;
				foreach($rows as $row){
					$dest_id = $row['ID'];
				}
				$query = "SELECT ID FROM locations WHERE location LIKE '".$pickingpoint."'";
				$rows = $pdo->query($query);
				$loc_id = null;
				foreach($rows as $row){
					$loc_id = $row['ID'];
				}
				$data = array($id_driver, $id_customer,1,1, $loc_id,$dest_id,$rating,$comment);
				$stmt = $pdo->prepare("INSERT INTO orders (driver_id, customer_id, customer_show, driver_show, location_id, destination_id, rate, comment) VALUES (?,?,?,?,?,?,?,?)");
				if($stmt->execute($data)){
					$ID = $pdo->lastInsertId();
					Database::disconnect();
				}
			} else {
				foreach ($_POST as $key => $value) {
					if($value==''){
						$status += $key . ', ';
					}
				}
				$status += "tidak boleh kosong";
			}
			Database::disconnect();
			echo "ok";
		} catch(PDOException $ex){
			echo $ex->getMessage();
		}
	}else{
		echo "not-okay";
	}
?>