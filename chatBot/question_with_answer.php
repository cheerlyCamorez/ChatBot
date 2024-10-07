<?
require_once "DB/DB.php";
require_once "helpers.php";

$db = new DB();
$categories=[];
$dataquestions=[];
$sql = 'SELECT * FROM Category_question;';
$result = $db->do_query($sql);
if($result->num_rows>0)
{while ($category_id = $result->fetch_assoc()){
    $categories[] = $category_id;
}};

$sql = "SELECT
id,
question,
answer,
(SELECT name FROM Category_question WHERE id = Questions_with_answers.category_id) AS category
FROM
Questions_with_answers
ORDER BY id;";
$resultt = $db->do_query($sql);
if ($resultt->num_rows>0){
    while ($category = $resultt->fetch_assoc()){
        $dataquestions[]=$category;
    }
}
var_dump($resultt);
$content = include_template("question_with_answer.php", 
['dataquestions'=> $dataquestions,
'categories' => $categories,
'adv' => $adv]);
$title = "Главная";
echo include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'dataquestions' => $dataquestions 
]);

?>