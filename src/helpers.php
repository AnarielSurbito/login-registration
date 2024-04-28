<?php

require_once __DIR__ . '/master.php';

session_start();

//Перенаправление
function redirect(string $path)
{
    header("Location: $path");
    die();
}


//Работа с ошибками валидации
function setValidationError(string $fieldName, string $message){
    $_SESSION['validation'][$fieldName] = $message;
}


function hasValidationError(string $fiealdName):bool
{
    return isset($_SESSION['validation'][$fiealdName]);
}


function validationErrorAttr(string $fiealdName){
    echo isset($_SESSION['validation'][$fiealdName]) ? 'aria-invalid="true"' : '';
}


function validationErrorMessage(string $fiealdName){
    $message = $_SESSION['validation'][$fiealdName] ?? '';
    unset($_SESSION['validation'][$fiealdName]);
    return $message;
}


//Работа со старыми значениями
function setOldValue(string $key, mixed $value){
    $_SESSION['old'][$key] = $value;
}

function old(string $key){
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

//
function setMessage(string $key, string $message): void
{
    $_SESSION['message'][$key] = $message;
}

//Вывод сообщений
function hasMessage(string $key)
{
    return isset($_SESSION['message'][$key]);
}

function getMessage(string $key):string{
    $message = $_SESSION['message'][$key] ?? '';
    unset($_SESSION['message'][$key]);
    return $message;
}

//Проверка правильности пароля
function check_password($login = '', $password = '', $hashPassword = ''){
    $salt = $login;
    $hash = sha1($salt.$password);
    if ($hash == $hashPassword) {
        return true;
    }else{
        return false;
    }
}


//Выход из учётной записи
function logout(): void
{
    unset($_SESSION['user']['id']);
    redirect(path: '/');
}

//Проверка аутентификации
function checkAuth(): void
{
    if (!isset($_SESSION['user']['id'])) {
        redirect('/');
    }
}

//Проверка, не зашёл ли пользователь
function checkGuest(): void
{
    if (isset($_SESSION['user']['id'])) {
        redirect('/home.php');
    }
}