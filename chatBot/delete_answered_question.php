<?
require_once "DB/DB.php";
require_once "helpers.php";

$id=$_GET['id'];
$db = new DB();
$sql = "DELETE FROM Questions_with_answers WHERE id=$id;";
$result = $db->do_query($sql);
header("Location: question_with_answer.php");
?>