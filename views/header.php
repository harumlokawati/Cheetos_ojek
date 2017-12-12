<!DOCTYPE html>
<?php
  require_once($_SERVER['DOCUMENT_ROOT']."/helpers/UserHelper.php");
  UserHelper::getUser($_GET['id_active']);
  $ID = UserHelper::getID();
  if($ID == null){
      header('location: login.php');
  }
  $file = $_SERVER['PHP_SELF'];
  $path = "http://".$_SERVER['HTTP_HOST'];
  $order_page = $file=="/order.php";
  $history_page = $file=="/history.php";
  $profile_page = $file=="/profile.php" || $file=="/edit_profile.php";
?>
<html>
    <head>
        <title>Order PR-Ojek</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/element.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <div class="default-extern-container">
            <div class="row">
                <div class="col-6">
                    <h1 class="logo"><span style="color: #034E03;">PR</span>-<span style="color:red;">OJEK</span></h1>
                    <h2 class="tagline" style="color: #468D03;">wushh... wushh... ngeeeeeenggg...</h2>
                </div>
                <div class="col-6 align-right">
                    <p>Hello, <strong><?php echo UserHelper::getUsername(); ?></strong> !</p>
                    <a href="<?php echo $path;?>">Logout</a>
                </div>
            </div>
            <ul class="row navbar">
                <li class="col-4 align-center standard-border <?php if($order_page){ ?>active<?php } ?>"><a href="<?php echo $path.'/order.php?id_active='.$ID; ?>">Order</a></li>
                <li class="col-4 align-center standard-border <?php if($history_page){ ?>active<?php } ?>"><a href="<?php echo $path.'/history.php?id_active='.$ID; ?>">History</a></li>
                <li class="col-4 align-center standard-border <?php if($profile_page){ ?>active<?php } ?>"><a href="<?php echo $path.'/profile.php?id_active='.$ID; ?>">My Profile</a></li>
            </ul>