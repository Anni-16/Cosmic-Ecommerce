<?php
require_once('header.php');

// Redirect if no ID provided
if (!isset($_REQUEST['id']) || !is_numeric($_REQUEST['id'])) {
    header("Location: news-events.php");
    exit;
}

$news_id = $_REQUEST['id'];

// Check if news exists
$stmt = $pdo->prepare("SELECT * FROM tbl_news WHERE news_id = ?");
$stmt->execute([$news_id]);
$news = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$news) {
    header("Location: news-events.php");
    exit;
}

// Delete main image
$main_image = $news['b_image'];
$main_image_path = './uploads/news/' . $main_image;
if ($main_image != '' && file_exists($main_image_path)) {
    unlink($main_image_path);
}

// Delete gallery images
$stmt_gallery = $pdo->prepare("SELECT * FROM tbl_news_photo WHERE news_id = ?");
$stmt_gallery->execute([$news_id]);
$gallery_photos = $stmt_gallery->fetchAll(PDO::FETCH_ASSOC);

foreach ($gallery_photos as $photo) {
    $gallery_path = './uploads/news/gallery/' . $photo['photo'];
    if (file_exists($gallery_path)) {
        unlink($gallery_path);
    }
}

// Delete gallery image records
$stmt = $pdo->prepare("DELETE FROM tbl_news_photo WHERE news_id = ?");
$stmt->execute([$news_id]);

// Delete the news record
$stmt = $pdo->prepare("DELETE FROM tbl_news WHERE news_id = ?");
$stmt->execute([$news_id]);

// Redirect
header("Location: news-events.php");
exit;
?>
