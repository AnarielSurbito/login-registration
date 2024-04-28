<?php

require_once __DIR__ . '/../helpers.php';
require_once __DIR__ . '/../master.php';

$master = new Master();

//Установка необходимых переменных
$login = $_POST['login'] ?? null;
$password = $_POST['password'] ?? null;
$passwordConfirmation = $_POST['password_confirmation'] ?? null;
$email = $_POST['email'] ?? null;
$name = $_POST['name'] ?? null;


// Проверки для логина
if (empty($login)) {
    setValidationError(fieldName:'login', message: 'Логин не может быть пустым');
}

if (strlen($login)<6){
    setValidationError(fieldName: 'login', message:'Логин должен состоять минимум из 6 символов');
}

if (!preg_match("#^[aA-zZ0-9]+$#",$login)){
    setValidationError(fieldName: 'login', message:'Пароль должен содержать только числа и буквы');
}

if($master->get_data('login', $login)){
    setValidationError(fieldName: 'login', message: 'Пользователь с таким логином уже существует');
}


//Проверки для пароля
if (empty($password)) {
    setValidationError(fieldName: 'password', message:'Пароль не может быть пустым');
}

if (strlen($password)<6){
    setValidationError(fieldName: 'password', message:'Пароль должен состоять минимум из 6 символов');
}

if (!preg_match("#^[aA-zZ0-9]+$#",$password)){
    setValidationError(fieldName: 'password', message:'Пароль должен содержать только числа и буквы');
}

if ($password !== $passwordConfirmation) {
    setValidationError(fieldName: 'password', message:'Пароли не совпадают');
}


//Проверки для почти
if (empty($email)) {
    setValidationError(fieldName:'email', message: 'Укажите почту');
}

if (!filter_var($email, filter:FILTER_VALIDATE_EMAIL)) {
    setValidationError(fieldName: 'email', message: 'Неправильно указана почта');
}

if($master->get_data('email', $email)){
    setValidationError(fieldName: 'email', message: 'Такая почта уже есть');
}

//Проверки для имени
if (empty($name)) {
    setValidationError(fieldName:'name', message: 'Неверное имя');
}

if (strlen($name)<2){
    setValidationError(fieldName: 'name', message:'Имя должно состоять минимум из 2 символов');
}

if (!preg_match("#^[aA-zZ]+$#",$name)){
    setValidationError(fieldName: 'name', message:'Имя должно содержать только буквы');
}

if (!empty($_SESSION['validation'])){
    setOldValue('name', $name);
    setOldValue('email', $email);
    setOldValue('login', $login);
    redirect(path: '/register.php');
}

//Добавить пользователя
$master->insert_to_json();

/* $val = 0;
$array = [
    'id' => $val,
    'login' => $login,
    'password'=> password_hash($password, algo:PASSWORD_DEFAULT),
    'email'=> $email,
    'name'=> $name
];

$json = json_encode($array, JSON_UNESCAPED_UNICODE);
$file = 'db.json';
$payload = file_exists($file) ? "[{$json}]" : "[{$json}]";
$fileHander = fopen($file, "c");
fseek($fileHander, -1, SEEK_END);
fwrite($fileHander, $payload);
fclose($fileHander); */



redirect(path:'/index.php');