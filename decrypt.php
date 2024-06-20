<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = hex2bin("c4d3c69c3b12a92399b7ad0c51f343e6c36b73419d3e18e6e05e405c2bff5f73");

    $input = json_decode(file_get_contents('php://input'), true);

    error_log('Received data: ' . print_r($input, true));

    if (isset($input['value'])) {
        $encrypted = base64_decode($input['value']);

        $nonce = substr($encrypted, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $ciphertext = substr($encrypted, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $decrypted = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);

        if ($decrypted === false) {
            error_log('Decryption failed');
            echo json_encode(['value' => 'Ошибка дешифрования']);
        } else {
            error_log('Decrypted value: ' . $decrypted);
            echo json_encode(['value' => $decrypted]);
        }
    } else {
        error_log('Value not set in received data');
        echo json_encode(['value' => 'Ошибка получения данных']);
    }
} else {
    echo json_encode(['value' => 'Неверный метод запроса']);
}
?>
