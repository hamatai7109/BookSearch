<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

//DB接続
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}

//検索履歴を取得
$sql= "SELECT * FROM search_history ORDER BY search_date DESC";
$result = $conn->query($sql);

$history = [];
while($row = $result->fetch_assoc()){
  $history[] = $row;
}

echo json_encode($history);
?>