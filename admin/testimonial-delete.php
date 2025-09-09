<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
	// Getting photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_testimonial WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$testimonial_photo = $row['testimonial_photo'];
		unlink('./uploads/testimonial/'.$testimonial_photo);
	}


	// Delete from tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_testimonial WHERE id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: testimonial.php');
?>