<?php

include('func.php');

include('database.php');

$botToken = '787626658:AAHOBKDxO8nOAYbjxVfZZGgMPYgsMGX6VKE'; 

$update = file_get_contents('php://input'); 
$update = json_decode($update, true);  

if (isset($update['message'])) { 
    $message = $update['message'];    
    $chatId = $message['chat']['id']; 
    $text = $message['text'];  

    if (stristr("$text", "/start")) {          
        $text = 'Приветствую тебя, '. $message['from']['first_name'] ." в САФУ боте";          
        sendMessage($chatId, $text);
        sendMessage($chatId, "Дальнейшие действия выполняй через меню");

    }
    elseif ($text == '/act'){
        $buttons = array(            
            array( 
                array('text' => 'Подписаться на рассылку', 'callback_data' => 'sub')            
            ),
            array( 
                array('text' => 'Отписаться от рассылки', 'callback_data' => 'unsub')            
            ),             
            array( 
                array('text' => 'Задать вопрос', 'callback_data' => 'ask')            
            ) 
        );  
        $inlinekeyboard = array(            
            'inline_keyboard' => $buttons
        );        
        $inlinekeyboard = json_encode($inlinekeyboard); 
        $response = 'Выберите действие:'; 
        sendMessageWithKeyboard($chatId, $response, $inlinekeyboard);
    } 
    elseif ($text == '/faq') { 
        $buttons = array(
            array( 
                array('text' => 'Sakai', 'callback_data' => '1')            
            ),
            array( 
                array('text' => 'Общежития', 'callback_data' => '2')            
            ),             
            array( 
                array('text' => 'Корпуса обучения', 'callback_data' => '3')            
            ),
            array( 
                array('text' => 'Поиск контекстного вопроса', 'callback_data' => 'find')            
            ) 
        );  
        $inlinekeyboard = array(            
            'inline_keyboard' => $buttons
        );        
        $inlinekeyboard = json_encode($inlinekeyboard); 
        $response = 'Выберите категорию или найдите вопрос по слову:'; 
        sendMessageWithKeyboard($chatId, $response, $inlinekeyboard); 
    }
    elseif (stristr("$text", "/auth")) {
        if (login($conn, $chatId)){
            sendMessage($chatId, "Вы уже авторизированы");
            sendMessage($chatId, "Нажмите /act -> Задать вопрос");
        }
        else {
            sendMessage($chatId, "Для начала необходимо авторизоваться");
            sendMessage($chatId, "Введите через запятую
            Имя и Фамилию, 
            Город, 
            Уровень обучения(цифра), 
            Программу обучения, 
            Email");
            sendMessage($chatId, "Уровни обучения: 
            1 - Начальное общее, 
            2 - Основное общее, 
            3 - Среднее общее, 
            4 - Среднее профессиональное, 
            5 - Бакалавриат, 
            6 - Магистратура");
            sendMessage($chatId, "Пример - Иван Иванов, Архангельск, 5, Прикладная информатика, safu@mail.ru");
        }
    }
    elseif (strrchr("$text", "?")) {
        if (login($conn, $chatId)){
            ask($conn);
        }
        else{
            sendMessage($chatId, "Неправильная команда");
        }
    }
    elseif (stristr("$text", ",")) {
        if (!login($conn, $chatId)){
            add($conn);
        }
        else{
            sendMessage($chatId, "Неправильная команда");
        }
    }
    else{
        find($conn, $chatId);
    }
}


if (isset($update['callback_query'])) {
    category($conn);
}
mysqli_close($conn); 
?>
