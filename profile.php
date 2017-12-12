<?php include 'views/header.php'; ?>
<?php include 'controllers/ProfileController.php'; ?>
<?php 
	$page = null;
	if(isset($_GET["edit"])) {
		$page = $_GET["edit"];
		if($page=='profile'){
			include 'views/edit_profile.php';
		} elseif ($page=='location'){
			include 'views/edit_location.php';
		} 
	} else {
		include 'views/profile_view.php';
	}
?>

<?php include 'views/footer.php'; ?>