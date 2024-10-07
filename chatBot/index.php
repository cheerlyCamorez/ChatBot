<?

require_once "DB/DB.php";
require_once "helpers.php";

$title = "Главная";
header('Location: question_with_answer.php');
echo include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'categories' => $categories 
]);
?>