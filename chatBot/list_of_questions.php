<?

require_once "DB/DB.php";
require_once "helpers.php";

$educationLevels=[];
$categories=[];
$db = new DB();


$sql = 'SELECT * FROM level_education;';
$result = $db->do_query($sql);
if($result->num_rows>0)
{while ($category_id = $result->fetch_assoc()){
    $categories[] = $category_id;
}};

$sql = "SELECT question_from_user.id, 
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
ORDER BY question_from_user.id;";
$resultt = $db->do_query($sql);
if ($resultt->num_rows>0){
    while ($category = $resultt->fetch_assoc()){
        $educationLevels[]=$category;
    }
}

$content = include_template("list_of_questions.php", 
['educationLevels'=> $educationLevels,
'categories' => $categories,
'adv' => $adv]);
$title = "Главная";
echo include_template('layout.php', [
    'title' => $title,
    'content' => $content,
    'educationLevels' => $educationLevels 
]);
?>