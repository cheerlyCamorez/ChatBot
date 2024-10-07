<?
require_once "DB/DB.php";
require_once "helpers.php";

$categories=[];
$questions=[];
$db = new DB();


$sql = 'SELECT * FROM Category_question;';
$result = $db->do_query($sql);
if($result->num_rows>0)
{while ($category_id = $result->fetch_assoc()){
    $categories[] = $category_id;
}};
$id = $_GET['id'];
$sql ="SELECT 
Questions_with_answers.id,
Questions_with_answers.question,
Questions_with_answers.answer,
Category_question.name as category_name
FROM Questions_with_answers
JOIN Category_question ON Questions_with_answers.category_id = Category_question.id
WHERE Questions_with_answers.id=$id;";
$result = $db -> do_query($sql);
var_dump($result);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $questions[] = $row;
    }
}

if (count($_POST) > 2 && isset($_POST['submit_button'])) {
    $id_question = $_GET['id'];
    $config_name = $_POST['name'] ?? null;
    $config_answer = $_POST['answer'] ?? null;
    $config_category_id = $_POST['category_id'] ?? null;

    // Формирование начала SQL-запроса
    $sql = "UPDATE Questions_with_answers SET ";

    // Добавление условий, если поле не пустое
    if ($config_name !== null) $sql .= "question = '$config_name', ";
    if ($config_answer !== null) $sql .= "answer = '$config_answer', ";
    if ($config_category_id !== null) $sql .= "category_id = $config_category_id, ";

    // Удаление последней запятой и пробела
    $sql = rtrim($sql, ', ');

    // Замените your_table_name и id на ваши реальные значения
    $sql .= " WHERE id = '$id_question';";

    $result = $db->do_query($sql);
    var_dump($result);
    if ($result) {
        header('Location: question_with_answer.php');
    }
}
$content = include_template("redact_question.php", 
['categories'=> $categories,
'questions' => $questions,
'adv' => $adv]);
$title = "Главная";
echo include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories,
    'questions' => $questions, 
]);

?>