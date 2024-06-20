<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $id = intval($_POST['id']);

    // Получить user_id на основе заказа
    $query = "SELECT user_id FROM user_books WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Проверить, есть ли у пользователя просроченные заказы
        if ($action === 'approve') {
            $queryOverdue = "SELECT COUNT(*) as overdue_count FROM user_books WHERE user_id = '$user_id' AND status = 'overdue'";
            $resultOverdue = mysqli_query($conn, $queryOverdue);

            if ($resultOverdue) {
                $rowOverdue = mysqli_fetch_assoc($resultOverdue);
                
                if ($rowOverdue['overdue_count'] > 0) {
                    echo json_encode(['message' => 'У пользователя есть просроченные заказы. Новый заказ не может быть одобрен.']);
                    exit();
                }
            } else {
                echo json_encode(['message' => 'Ошибка при выполнении запроса на просроченные заказы: ' . mysqli_error($conn)]);
                exit();
            }
        }

        // Обработка действия
        if ($action === 'approve') {
            $days = intval($_POST['days']);
            $rent_date = date('Y-m-d', strtotime("+$days days"));
            $query = "UPDATE user_books SET status = 'approved', rent_date = '$rent_date' WHERE id = $id";
        } elseif ($action === 'reject') {
            $query = "UPDATE user_books SET status = 'rejected' WHERE id = $id";
        } elseif ($action === 'complete') {
            $query = "UPDATE user_books SET status = 'completed' WHERE id = $id";
        }

        if (mysqli_query($conn, $query)) {
            echo json_encode(['message' => 'Статус заказа успешно обновлен']);
        } else {
            echo json_encode(['message' => 'Ошибка при обновлении статуса заказа: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['message' => 'Заказ не найден']);
    }
}
?>
