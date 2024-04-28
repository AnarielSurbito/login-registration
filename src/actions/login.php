<?php

require_once __DIR__ .'/../helpers.php';
require_once __DIR__ .'/../master.php';

$master = new Master();

//Установка необходимых переменных
$login = $_POST['login'] ?? null;
$passwords = $_POST['password'] ?? null;


//Проверка логина
if (empty($login)) {
    setOldValue('login', $login);
    setValidationError(fieldName:'login', message: 'Введите логин');
    setMessage(key: 'error', message:'Ошибка в логине');
    redirect(path:'/');
}

$user = $master->get_data('login', $login);

if (!$user) {
    setMessage(key: 'error', message: "Пользователя $login не существует");
    redirect(path:'/');
}
 

//Проверка пароля
if (!check_password($login, $passwords, $user->password)){
    setMessage(key: 'error', message: "Неверный пароль");
    redirect(path:'/');
}



$_SESSION['user']['id'] = $user->id;
$_SESSION['user']['name'] = $user->name;

redirect(path:'/home.php');