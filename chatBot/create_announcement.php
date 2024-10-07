<?
require_once "DB/DB.php";
require_once "helpers.php";
$db = new DB();
$errors=[];
$categories=[];
$anons=[];
if($_POST['text'] == ''){
    $errors['text'] = 'Введите текст';
}
if($_POST['category_id'] == ''){
    $errors['category_id'] = 'Выберите категорию';
}
$sql = 'SELECT * FROM Category_question;';
$result = $db->do_query($sql);
if($result->num_rows>0)
{while ($category_id = $result->fetch_assoc()){
    $categories[] = $category_id;
}};
$text = $_POST['text'];
$category_id = $_POST['category_id'];
if ((count($errors) == 0) and isset($_POST['submit_button'])){
    $sql="INSERT INTO list_of_announcements (text, category_id) VALUES ('$text', $category_id);";
    $dogovor = $db->do_query($sql);
    $sql = "SELECT * FROM list_of_subscribers";
    $result = $db->do_query($sql);
    if ($result->num_rows > 0){
        while ($res = $result->fetch_assoc()){
            $anons[]=$res;
        }
    }
    foreach($anons as $anon){
        if ($anon['id_category'] == $category_id){
            sendMessage($anon['id_tg_user'], $text);
        }
    }
}
$content = include_template("create_announcement.php", 
['errors'=> $errors,
 'categories' => $categories,
 'anons' => $anons
]);
$title = "Главная";
echo include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'errors' => $errors 
]);

?>