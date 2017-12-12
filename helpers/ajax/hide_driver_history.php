<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/dbconn.php");
    $id = null;
    if (!empty($_POST['id'])){
        $id = $_POST['id'];
    }

    if ($id != null){
        try{
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = 'UPDATE orders SET driver_show = 0 WHERE ID='.$id;
            $query = $pdo->prepare($sql); 
            $query->execute(array($id));
            Database::disconnect();
            echo true;
        }
        catch (Exception $e){
            echo false;
        }
    }
?>