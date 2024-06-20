<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_image"])) {
    $userId = $_SESSION["user_id"];

    $uploadDir = 'user_images/';

    if ($_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
        die('Ошибка при загрузке файла.');
    }

    $extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);

    $newFileName = $userId . '.' . $extension;

    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath)) {
        require_once 'config.php';

        $updateQuery = "UPDATE users SET avatar='$uploadPath' WHERE id='$userId'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            echo 'Изображение профиля успешно загружено и путь обновлен в базе данных.';
        } else {
            echo 'Ошибка при обновлении пути в базе данных: ' . mysqli_error($conn);
        }
    } else {
        echo 'Ошибка при перемещении файла в указанную директорию.';
    }
}
?>

