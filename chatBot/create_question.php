<?
require_once "DB/DB.php";
require_once "helpers.php";
$db = new DB();
$errors=[];
$categories=[];

if($_POST['name'] == ''){
    $errors['name'] = 'Введите вопрос';
}
if($_POST['answer'] == ''){
    $errors['answer'] = 'Введите ответ';
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
$name = $_POST['name'];
$answer = $_POST['answer'];
$category_id = $_POST['category_id'];
if ((count($errors) == 0) and isset($_POST['submit_button'])){
    $sql="INSERT INTO Questions_with_answers (question, answer, category_id) VALUES ('$name', '$answer', $category_id);";
    $dogovor = $db->do_query($sql);
    var_dump($dogovor);
    if ($dogovor->num_rows > 0){
        $dog = $dogovor->fetch_assoc();
    }
}
$content = include_template("create_question.php", 
['errors'=> $errors,
 'categories' => $categories
]);
$title = "Главная";
echo include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'errors' => $errors 
]);

?>