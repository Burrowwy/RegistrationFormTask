<?php
// Получение данных из AJAX запроса
$firstName = $_POST['username'];
$lastName = $_POST['userSurname'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirmation = $_POST['confirmPassword'];


// Валидация на сервере
if (strpos($email, '@') === false) {
    $response = ['message'=> 'Email должен содержать @', 'userExists' => true];
    echo json_encode( $response);
} elseif ($password !== $password_confirmation) {
    $response = ['message'=> 'Пароли не совпадают', 'userExists' => true];
    echo json_encode( $response);
} else {
    // Задаем массив пользователей
    $userExists = false;
    $existingUsers = [
        ['id' => 1, 'name' => 'Иван', 'email' => 'bbb@example.com'],
        ['id' => 2, 'name' => 'Андрей', 'email' => 'machi@example.com'],
        ['id' => 3, 'name' => 'Алина', 'email' => 'machi@example.com'],
    ];
    // Проверяем, существует ли пользователь с таким email
    
    foreach ($existingUsers as $user) {
        if ($user['email'] === $email) {
            $userExists = true;
            break;
        }
    }
    // имя файла с логами
    $filename ='registrationLog.txt';

    if ($userExists) {
        // Логирование результата в файл
        $logMessage = "Пользователь с email: $email уже существует  Дата:". date ("F d Y H:i:s.", filemtime($filename));

        file_put_contents($filename, $logMessage . PHP_EOL, FILE_APPEND);

        $response = ['message'=> "Этот email пользователя уже используется", 'userExists' => $userExists];

        echo json_encode($response);

    } else {$registrationMessage = "Регистрация пользователя:  Имя:$firstName  Фамилия:$lastName, email: $email  Дата:". date ("F d Y H:i:s.", filemtime($filename));
        // Логирование результата в файл

        file_put_contents($filename, $registrationMessage . PHP_EOL, FILE_APPEND);

        $response = ['message'=> 'Регистрация успешна', 'userExists' => $userExists];

        echo json_encode($response);
    }
 }
 ?>