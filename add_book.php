<?php
require_once 'config.php';

$title = $_POST['title'];
$cover = $_POST['cover'];
$author = $_POST['author'];
$description = $_POST['description'];
$year = $_POST['year'];
$genre1 = $_POST['genre1'];
$genre2 = $_POST['genre2'];
$genre3 = $_POST['genre3'];
$pdfLink = $_POST['pdf_link'];
$type = $_POST['type'];
$size = $_POST['size'];

$query = "INSERT INTO library (title, cover, author, description, year, genre1, genre2, genre3, pdf_link, type, size) 
          VALUES ('$title', '$cover', '$author', '$description', '$year', '$genre1', '$genre2', '$genre3', '$pdfLink', '$type', '$size')";

if (mysqli_query($conn, $query)) {
    header("Location: adminpage.php"); 
} else {
    echo "Ошибка при добавлении книги: " . mysqli_error($conn);
}
?>