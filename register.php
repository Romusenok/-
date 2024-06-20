<?php
require_once 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$middleName = $_POST['middleName'];
$phone = $_POST['phone'];
$passportSeries = $_POST['passportSeries'];
$passportNumber = $_POST['passportNumber'];

$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo json_encode(array('success' => false, 'message' => 'Пользователь с таким логином уже существует'));
    exit();
}

$key = hex2bin("c4d3c69c3b12a92399b7ad0c51f343e6c36b73419d3e18e6e05e405c2bff5f73");

$nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

$ciphertext = sodium_crypto_secretbox($password, $nonce, $key);

$encryptedPassword = base64_encode($nonce . $ciphertext);

$ciphertext = sodium_crypto_secretbox($firstName, $nonce, $key);

$encryptedFirstName = base64_encode($nonce . $ciphertext);

$ciphertext = sodium_crypto_secretbox($lastName, $nonce, $key);

$encryptedLastName = base64_encode($nonce . $ciphertext);

$ciphertext = sodium_crypto_secretbox($middleName, $nonce, $key);

$encryptedMiddleName = base64_encode($nonce . $ciphertext);

$ciphertext = sodium_crypto_secretbox($phone, $nonce, $key);

$encryptedPhone = base64_encode($nonce . $ciphertext);

$ciphertext = sodium_crypto_secretbox($passportSeries, $nonce, $key);

$encryptedSeries = base64_encode($nonce . $ciphertext);

$ciphertext = sodium_crypto_secretbox($passportNumber, $nonce, $key);

$encryptedNumber = base64_encode($nonce . $ciphertext);

$defaultAvatar = 'user_images/0.jpg';

$currentDate = date('Y-m-d');

$query = "INSERT INTO users (username, password, admin, registration_date, avatar, firstName, lastName, middleName, phone, passportSeries, passportNumber) VALUES ('$username', '$encryptedPassword', 0, '$currentDate', '$defaultAvatar', '$encryptedFirstName', '$encryptedLastName', '$encryptedMiddleName', '$encryptedPhone', '$encryptedSeries', '$encryptedNumber')";
$result = mysqli_query($conn, $query);

if ($result) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}
?>