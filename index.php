<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>書籍検索アプリ</title>
  <script type="text/javascript" src="index.js"></script>
</head>
<body>
  <main>
    <div class="container">
      <h1 class="title">書籍検索アプリ</h1>
      <div class="searchBox">
        <form id="searchForm">
          <input type="text" id="searchInput" name="searchInput" placeholder="書籍名を入力">
          <input type="submit" value="検索">
        </form>
      </div>
      <div class="historyBox">
        <h2 class="historyTitle">検索履歴</h2>
        <div class="history" id="history"></div>
        <h2 class="historyResult">検索結果</h2>
        <div class="result" id="result"></div>
      </div>
    </div>
  </main>
</body>
</html>