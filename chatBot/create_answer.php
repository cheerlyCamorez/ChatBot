<?
require_once "DB/DB.php";
require_once "helpers.php";
$db = new DB();
$errors=[];
$categories=[];
$dataquestions=[];


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
$id=$_GET['id'];
$sql1 = "SELECT question_from_user.id, 
question_from_user.question_from_user as ask, 
question_from_user.user_id, 
User_information.name_surname AS name_surname, 
User_information.education AS education, 
User_information.level_of_education_id, 
level_education.name_level_education AS name_level_education, 
User_information.programm_of_education AS programm_of_education, 
User_information.e_mail AS e_mail, 
User_information.id_user_tg AS id_user_tg 
FROM question_from_user 
JOIN User_information ON question_from_user.user_id = User_information.id 
JOIN level_education ON User_information.level_of_education_id = level_education.id 
WHERE question_from_user.id=$id;";
$resultt = $db->do_query($sql1);
if ($resultt->num_rows>0){
    while ($category = $resultt->fetch_assoc()){
        $dataquestions[]=$category;
    }
}

if (isset($_POST['submit_button'])){
    $id = $_POST['id'];
    $id_tg = $_POST['id_tg'];
    $answer = $_POST['answer'];
    $category_id = $_POST['category_id'];
    $ask = $_POST['ask'];
    $sql = "INSERT INTO Questions_with_answers (question, answer, category_id) VALUES ('$ask', '$answer', $category_id);";
    $dogovor = $db->do_query($sql);
    if($dogovor){
        sendMessage($id_tg, $answer);
        $sql = "DELETE FROM Question_from_user WHERE id=$id";
        $result = $db->do_query($sql);
        var_dump($result);
        if ($result){
            header('Location: list_of_questions.php');
            exit();
        }
    }
}
$content = include_template("create_answer.php", 
['errors'=> $errors,
 'categories' => $categories,
 'dataquestions' => $dataquestions
]);
$title = "Главная";
echo include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'errors' => $errors, 
    'categories' => $categories,
    'dataquestions' => $dataquestions
]);


?>