<?php
require_once 'config.php';

session_start();

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$key = hex2bin("c4d3c69c3b12a92399b7ad0c51f343e6c36b73419d3e18e6e05e405c2bff5f73");

$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $encryptedPassword = base64_decode($user['password']);

    $nonce = substr($encryptedPassword, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

    $ciphertext = substr($encryptedPassword, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

    $decryptedPassword = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);

    if ($decryptedPassword === false) {
        echo json_encode(array("success" => false, "message" => "Ошибка дешифрования пароля"));
        exit();
    }

    if ($password === $decryptedPassword) {
        $_SESSION['user_id'] = $user['id'];

        if ($user['admin'] == 1) {
            $_SESSION['is_admin'] = true;
        }

        if ($user['admin'] == 2) {
            $_SESSION['is_librarian'] = true;
        }


        echo json_encode(array("success" => true, "user_id" => $user['id']));
    } else {
        echo json_encode(array("success" => false, "message" => "Неверный пароль"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Пользователь не найден"));
}
?>
