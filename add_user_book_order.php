<?php
session_start();

require_once 'config.php';

$userId = $_POST['userId'] ?? null;
$bookId = $_POST['bookId'] ?? null;

if ($userId && $bookId) {
    $query = "SELECT * FROM user_books WHERE user_id = $userId AND book_id = $bookId AND status = 'order'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO user_books (user_id, book_id, status, date_added) VALUES ($userId, $bookId, 'order', NOW())";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $response = array("success" => true, "message" => "Книга успешно добавлена пользователю");
            echo json_encode($response);
        } else {
            $response = array("success" => false, "message" => "Ошибка при добавлении книги пользователю");
            echo json_encode($response);
        }
    } else {
        $response = array("success" => false, "message" => "Книга уже есть у пользователя");
        echo json_encode($response);
    }
} else {
    $response = array("success" => false, "message" => "Неверные параметры запроса");
    echo json_encode($response);
}
?>
