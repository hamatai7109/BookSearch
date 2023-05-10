<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

$searchId = $_GET['id'];

//DB接続
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}

//検索結果を取得
$sql = "SELECT * FROM search_results WHERE search_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $searchId);
$stmt->execute();
$result = $stmt->get_result();

$results = [];
while($row = $result->fetch_assoc()){
  $results[] = $row;
}

echo json_encode($results);
?>