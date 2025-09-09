<?php require_once('header.php'); ?>

<?php
if (!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check if the ID exists in the database
    $statement = $pdo->prepare("SELECT * FROM tbl_banner WHERE id=?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();

    if ($total == 0) {
        header('location: logout.php');
        exit;
    }
}

// Fetch banner details to delete associated images
$statement = $pdo->prepare("SELECT * FROM tbl_banner WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $ser_image = $result['ser_image'] ?? '';
    $ser_image_2 = $result['ser_image_2'] ?? '';
 
    $upload_dir = './uploads/banner/';

    if (!empty($ser_image) && file_exists($upload_dir . $ser_image)) {
        unlink($upload_dir . $ser_image);
    }
    if (!empty($ser_image_2) && file_exists($upload_dir . $ser_image_2)) {
        unlink($upload_dir . $ser_image_2);
    }

    
}

// Delete the banner record itself
$statement = $pdo->prepare("DELETE FROM tbl_banner WHERE id=?");
$statement->execute([$_REQUEST['id']]);

header('location: banner.php');
exit;
?>
