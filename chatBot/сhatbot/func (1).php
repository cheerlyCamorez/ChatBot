<?php

function sendMessageWithKeyboard($chatId, $message, $keyboard){
    global $botToken;    
    $url = "https://api.telegram.org/bot$botToken/sendMessage"; 
    $data = array(        
        'chat_id' => $chatId, 
        'text' => $message,        
        'reply_markup' => $keyboard 
    ); 
    $options = array(        
        'http' => array( 
            'method' => 'POST',            
            'header' => 'Content-Type: application/json', 
            'content' => json_encode($data)        
        ) 
    ); 
    $context = stream_context_create($options);    
    $result = file_get_contents($url, false, $context); 
    return $result; 
} 

function sendMessage($chatId, $message) {
    global $botToken; 
    $url = "https://api.telegram.org/bot$botToken/sendMessage";    
    $data = array( 
        'chat_id' => $chatId,        
        'text' => $message,
        'parse_mode' => 'HTML' 
    ); 
    $options = array(        
        'http' => array( 
            'method' => 'POST', 
            'header' => 'Content-Type: application/x-www-form-urlencoded',            
            'content' => http_build_query($data) 
        )    
    ); 
    $context = stream_context_create($options); 
    $result = file_get_contents($url, false, $context); 
    return $result;
}


function category($conn){
    global $update;
    global $text;
    $chatId = $update['callback_query']['message']['chat']['id'];
    $callbackData = $update['callback_query']['data'];
    if ($callbackData == 'ask'){
        if (login($conn, $chatId)){
            sendMessage($chatId, "Напишите свой вопрос");
        }
        else {
            sendMessage($chatId, "Для начала необходимо авторизоваться");
            sendMessage($chatId, "Нажмите /auth");
        }
    }
    else if ($callbackData == 'unsub'){
        $buttons = array(            
            array( 
                array('text' => 'Sakai', 'callback_data' => 'unsub_cat1'),                
            ),
            array( 
                array('text' => 'Общежития', 'callback_data' => 'unsub_cat2')            
            ),             
            array( 
                array('text' => 'Корпуса обучения', 'callback_data' => 'unsub_cat3')            
            ) 
        );  
        $inlinekeyboard = array(            
            'inline_keyboard' => $buttons
        );        
        $inlinekeyboard = json_encode($inlinekeyboard); 
        $response = 'Выберите категорию от которой хотите отписаться:'; 
        sendMessageWithKeyboard($chatId, $response, $inlinekeyboard);
    }
    else if ($callbackData == 'unsub_cat1'){
        if (login_cat($conn, $chatId, '1')){
            $sql = "DELETE FROM list_of_subscribers WHERE id_tg_user = '$chatId' AND id_category = '1'";
            $result = mysqli_query($conn, $sql);
    
            if ($result) {
                sendMessage($chatId, "Вы успешно отписались от Sakai");
            } else {
            // Обработка ошибки выполнения запроса
            sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
            }
        }
        else{
            sendMessage($chatId, 'Вы еще не подписаны на Sakai');
        }
    }
    else if ($callbackData == 'unsub_cat2'){
        if (login_cat($conn, $chatId, '2')){
            $sql = "DELETE FROM list_of_subscribers WHERE id_tg_user = '$chatId' AND id_category = '2'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                sendMessage($chatId, "Вы успешно отписались от Общежития");
            } else {
            // Обработка ошибки выполнения запроса
            sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
            }
        }
        else{
            sendMessage($chatId, 'Вы еще не подписаны на Общежития');
        }   
    }
    else if ($callbackData == 'unsub_cat3'){
        if (login_cat($conn, $chatId, 3)){
            $sql = "DELETE FROM list_of_subscribers WHERE id_tg_user = '$chatId' AND id_category = '3'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                sendMessage($chatId, "Вы успешно отписались от Корпуса обучения");
            } else {
            // Обработка ошибки выполнения запроса
            sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
            }
        }
        else{
            sendMessage($chatId, 'Вы еще не подписаны на Корпуса обучения');
        }
    }
    else if ($callbackData == 'sub'){
        $buttons = array(            
            array( 
                array('text' => 'Sakai', 'callback_data' => 'sub_cat1'),                
            ),
            array( 
                array('text' => 'Общежития', 'callback_data' => 'sub_cat2')            
            ),             
            array( 
                array('text' => 'Корпуса обучения', 'callback_data' => 'sub_cat3')            
            ) 
        );  
        $inlinekeyboard = array(            
            'inline_keyboard' => $buttons
        );        
        $inlinekeyboard = json_encode($inlinekeyboard); 
        $response = 'Выберите категорию на которую хотите подписаться:'; 
        sendMessageWithKeyboard($chatId, $response, $inlinekeyboard);
    }
    else if ($callbackData == 'sub_cat1'){
        if (login_cat($conn, $chatId, '1')){
            sendMessage($chatId, 'Вы уже подписаны на Sakai');
        }
        else{
            $sql = "INSERT INTO list_of_subscribers (id_category, id_tg_user) VALUES ('1', '$chatId')";
            $result = mysqli_query($conn, $sql);
    
            if ($result) {
                sendMessage($chatId, "Успешно подписались на Sakai");
            } else {
            // Обработка ошибки выполнения запроса
            sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
            }
        }
    }
    else if ($callbackData == 'sub_cat2'){
        if (login_cat($conn, $chatId, '2')){
            sendMessage($chatId, 'Вы уже подписаны на Общежития');
        }
        else{
            $sql = "INSERT INTO list_of_subscribers (id_category, id_tg_user) VALUES ('2', '$chatId')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                sendMessage($chatId, "Успешно подписались на Общежития");
            } else {
            // Обработка ошибки выполнения запроса
            sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
            }
        }   
    }
    else if ($callbackData == 'sub_cat3'){
        if (login_cat($conn, $chatId, 3)){
            sendMessage($chatId, 'Вы уже подписаны на Корпуса обучения');
        }
        else{
            $sql = "INSERT INTO list_of_subscribers (id_category, id_tg_user) VALUES ('3', '$chatId')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                sendMessage($chatId, "Успешно подписались на Корпуса обучения");
            } else {
            // Обработка ошибки выполнения запроса
            sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
            }
        }
    }
    else if ($callbackData == 'find'){
        sendMessage($chatId, 'Введите слово, чтобы найти вопрос');
        sendMessage($chatId, 'Например, попробуйте написать слово \'Общежития\'');
    }
    else{
        $sql = "SELECT QWA.*, CQ.name
        FROM Questions_with_answers QWA
        JOIN Category_question CQ ON QWA.category_id = CQ.id
        WHERE QWA.category_id = $callbackData";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $lol = 'FAQ для категории <i>'.$row['name'].'</i>';
            sendMessage($chatId, $lol);
            $respons='';
            while($row){
                $response = "<b>Вопрос: ".$row['question']."</b>\n" . "<i>Ответ: ".$row['answer']. "</i>\n\n";
                $respons .= $response;
                $row = mysqli_fetch_assoc($result);
            }
            sendMessage($chatId, $respons);
        }
    }
}

function login($conn, $chatId){
    $query = "SELECT * FROM User_information WHERE id_user_tg LIKE '%$chatId%'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $lol2 = true;
            return $lol2;
        }
    } else {
        $lol2 = false;
        return $lol2;
    }
}

function ask($conn){
    global $update;

    $message = $update['message'];    
    $chatId = $message['chat']['id']; 
    $text = $message['text'];

    $query = "SELECT id FROM User_information WHERE id_user_tg = '$chatId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_query($conn, $query)) {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
    } else {
    // Обработка ошибки выполнения запроса
    sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
    }


    $query = "INSERT INTO question_from_user (question_from_user, user_id)
                VALUES ('$text', '$id')";

    if (mysqli_query($conn, $query)) {
        sendMessage($chatId, "Вопрос успешно записан");
    } else {
    // Обработка ошибки выполнения запроса
    sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
    }
}

function add($conn){
    global $update;

    $message = $update['message'];    
    $chatId = $message['chat']['id']; 
    $text = $message['text'];


    $array = explode(", ", $text);

    $query = "INSERT INTO User_information (name_surname, education, level_of_education_id, programm_of_education, e_mail, id_user_tg) 
    VALUES ('$array[0]', '$array[1]', '$array[2]', '$array[3]', '$array[4]', '$chatId')";

    if (mysqli_query($conn, $query)) {
        sendMessage($chatId, 'Авторизация прошла успешно');
        sendMessage($chatId, "Нажмите /act -> Задать вопрос");
    } else {
        sendMessage($chatId, "Ошибка: " . mysqli_error($conn));
    }
}

function login_cat($conn, $chatId, $cat) {

    $query = "SELECT * FROM list_of_subscribers WHERE id_tg_user LIKE '%$chatId%' AND id_category LIKE '%$cat%'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function find($conn, $chatId){
    global $text;
    $sql = "SELECT * FROM Questions_with_answers WHERE question LIKE '%$text%'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $respons='';
        while($row){
            $response = "<b>Вопрос: ".$row['question']."</b>\n" . "<i>Ответ: ".$row['answer']. "</i>\n\n";
            $respons .= $response;
            $row = mysqli_fetch_assoc($result);
        }
        sendMessage($chatId, $respons);
    }
    else{
        sendMessage($chatId, 'Неправильная команда');
    }
}



?>