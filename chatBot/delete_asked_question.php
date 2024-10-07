<?
require_once "DB/DB.php";
require_once "helpers.php";

$id=$_GET['id'];
$db = new DB();
$sql = "DELETE FROM question_from_user WHERE id=$id;";
$result = $db->do_query($sql);
header("Location: list_of_questions.php");

?>