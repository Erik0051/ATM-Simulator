<?php
include 'db.php';

function login($cardNumber, $pin) {
    global $conn;
    $cardNumber = mysqli_real_escape_string($conn, $cardNumber);
    $pin = mysqli_real_escape_string($conn, $pin);

    $query = "SELECT * FROM users WHERE card_number = '$cardNumber' AND pin = '$pin'";
    $result = mysqli_query($conn, $query);

    if ($user = mysqli_fetch_assoc($result)) {
        $_SESSION['user'] = $user;
        return true;
    }
    return false;
}


function getBalance() {
    return $_SESSION['user']['balance'] ?? 0;
}

function withdraw($amount) {
    global $conn;
    if (!isset($_SESSION['user'])) return "Ошибка! Не авторизован!";
    if ($amount <= 0) return "Некорректная сумма!";

    $userId = $_SESSION['user']['id'];
    $query = "SELECT balance FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $balance = $row['balance'];

    if ($balance >= $amount) {
        $newBalance = $balance - $amount;
        $updateQuery = "UPDATE users SET balance = '$newBalance' WHERE id = '$userId'";
        mysqli_query($conn, $updateQuery);

        $_SESSION['user']['balance'] = $newBalance;
        return "Вы сняли $amount ₽. Новый баланс: $newBalance ₽";
    } else {
        return "Недостаточно средств!";
    }
}


function deposit($amount) {
    global $conn;
    if (!isset($_SESSION['user'])) return "Ошибка! Не авторизован!";
    if ($amount <= 0) return "Некорректная сумма!";

    $userId = $_SESSION['user']['id'];
    $newBalance = $_SESSION['user']['balance'] + $amount;
    $updateQuery = "UPDATE users SET balance = '$newBalance' WHERE id = '$userId'";
    mysqli_query($conn, $updateQuery);

    $_SESSION['user']['balance'] = $newBalance;
    return "Вы пополнили баланс на $amount ₽. Новый баланс: $newBalance ₽";
}
?>
