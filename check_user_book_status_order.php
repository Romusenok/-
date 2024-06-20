<?php
session_start();

require_once 'config.php';

$userId = $_POST['userId'] ?? null;
$bookId = $_POST['bookId'] ?? null;

if ($userId && $bookId) {
    $query = "SELECT * FROM user_books WHERE user_id = $userId AND book_id = $bookId AND status = 'order'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $response = array("success" => true, "message" => "Книга уже прочитана пользователем");
        echo json_encode($response);
    } else {
        $response = array("success" => false, "message" => "Книги еще нет у пользователя или у нее другой статус");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "message" => "Неверные параметры запроса");
    echo json_encode($response);
}
?>
