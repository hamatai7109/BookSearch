<?php

header('Content-Type: application/json; charset=utf-8');
require_once 'config.php'; //ファイルがすでに読み込まれている場合は再読み込みをしない

$apiKey = 'AIzaSyAS55GzsDLuwCwUFbByL8U8I3fz4sggehc';

$searchQuery = $_POST['searchQuery'] ?? '';

//Google Books API
$url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($searchQuery) . "&maxResults=10&key=" . $apiKey;
$apiResponse = file_get_contents($url);
$books= json_decode($apiResponse, true);

//DB接続
$conn = new mysqli("DB_HOST", "DB_USER", "DB_PASSWORD", "DB_NAME");
if($conn->connect_error){
  die("Connection failed: " . $conn->connect_error);
}

//検索日時
$searchDate = date("Y-m-d H:i:s");

//検索履歴の保存
$stmt = $conn->prepare("INSERT INTO search_history(search_query, search_date) VALUES(?, ?)");
$stmt->bind_param("ss", $searchQuery, $searchDate);
$stmt->execute();
$searchId = $stmt->insert_id;

//検索結果を保持
foreach($books['items'] as $book){
  $volumeInfo = $book['volumeInfo'];
  $title = $volumeInfo['title'];
  $authors = implode(',', $volumeInfo['authors']);
  $description = $volumeInfo['description'];
  $infoLink = $volumeInfo['infoLink'];
  $smallThumbnail = $volumeInfo['imageLinks']['smallThumbnail'];

  $stmt = $conn->prepare("INSERT INTO search_results(search_id, title, authors, description, info_link, small_thumbnail) VALUES(?,?,?,?,?,?)");
  $stmt->bind_param("isssss",  $searchId, $title, $authors, $description, $infoLink,$smallThumbnail);
  $stmt->execute();
}
$stmt->close();
$conn->close();

//JSON形式で結果を返す
echo json_encode($books);
?>