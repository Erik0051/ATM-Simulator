<?php
session_start();
include 'bankomat.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $card = $_POST['card_number'];
        $pin = $_POST['pin'];
        if (login($card, $pin)) {
            header("Location: index.php");
        } else {
            $error_message = "Ошибка: неверный PIN или номер карты.";
        }
    }

    if (isset($_POST['withdraw'])) {
        $withdraw_message = withdraw($_POST['amount']);
    }

    if (isset($_POST['deposit'])) {
        $deposit_message = deposit($_POST['amount']);
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Банкомат</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Симулятор банкомата</h1>

        <?php if (!isset($_SESSION['user'])): ?>
            <form method="post" class="w-50 mx-auto">
                <div class="mb-3">
                    <label for="card_number" class="form-label">Номер карты:</label>
                    <input type="text" name="card_number" id="card_number" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="pin" class="form-label">PIN:</label>
                    <input type="password" name="pin" id="pin" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary w-100">Войти</button>
            </form>
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger mt-3 text-center"><?= $error_message ?></div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center mb-4">
                <p>Привет, ваша карта: <?= $_SESSION['user']['card_number'] ?></p>
                <p>Баланс: <?= getBalance() ?> ₽</p>
            </div>

            <form method="post" class="w-50 mx-auto mb-3">
                <div class="mb-3">
                    <label for="amount_withdraw" class="form-label">Сумма для снятия:</label>
                    <input type="number" name="amount" id="amount_withdraw" class="form-control" required>
                </div>
                <button type="submit" name="withdraw" class="btn btn-warning w-100">Снять</button>
            </form>
            <?php if (isset($withdraw_message)): ?>
                <div class="alert alert-warning text-center"><?= $withdraw_message ?></div>
            <?php endif; ?>

            <form method="post" class="w-50 mx-auto mb-3">
                <div class="mb-3">
                    <label for="amount_deposit" class="form-label">Сумма для пополнения:</label>
                    <input type="number" name="amount" id="amount_deposit" class="form-control" required>
                </div>
                <button type="submit" name="deposit" class="btn btn-success w-100">Пополнить</button>
            </form>
            <?php if (isset($deposit_message)): ?>
                <div class="alert alert-success text-center"><?= $deposit_message ?></div>
            <?php endif; ?>

            <form method="post" class="w-50 mx-auto">
                <button type="submit" name="logout" class="btn btn-danger w-100">Выйти</button>
            </form>
        <?php endif; ?>
    </div>

  


 
