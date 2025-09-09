<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE a_id=?");
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
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$a_photo = $row['a_photo'];
		unlink('./uploads/products/'.$a_photo);
	}

	// Getting other photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
		unlink('./uploads/products/'.$photo);
	}


	// Delete from tbl_photo
	$statement = $pdo->prepare("DELETE FROM tbl_product WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_product_photo
	$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE a_id=?");
	$statement->execute(array($_REQUEST['id']));


	header('location:product.php');
?>