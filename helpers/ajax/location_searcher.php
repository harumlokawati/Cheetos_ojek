<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    $loc = null;
    if(isset($_GET['location'])){
        $loc = $_GET['location'];
        $pdo = Database::connect();
        $query = "SELECT * FROM locations WHERE locations.location LIKE '%".$loc."%'";
        $data = $pdo->query($query);
        Database::disconnect();
        $i = 0;
        $result = array();
        $weight = array();
        foreach($data as $row){
            $locNow =$row['location'];
            $weightNow = strpos($locNow, $loc);
            $j = $i-1;
            $stop = false;
            while($stop && $j >= 0){
                if ($weight[$j] > $weightNow){
                    $weight[$j+1] = $weight[$j];
                    $result[$j+1] = $result[$j];
                } else {
                    $stop = true;
                }
                $j--;
            }
            $weight[$j+1] = $weightNow;
            $result[$j+1] = $locNow;
            $i++;
        }
        echo json_encode($result);
    }
?>