<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_social WHERE social_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}

	// Delete from tbl_mid_category
	$statement = $pdo->prepare("DELETE FROM tbl_social WHERE social_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: social-media.php');
?>