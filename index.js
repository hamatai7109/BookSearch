document.getElementById('searchForm').addEventListener('submit', async(event)=>{
  event.preventDefault();

  const searchInput = document.getElementById('searchInput').ariaValueMax;
  if(!searchInput) return;

  const response = await fetch('search.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'searchQuery=' + encodeURIComponent(searchInput)
  });

  const books = await response.json();

  //検索結果を表示
  let resultsHTML = '';
  for(const book of books.items){
    const volumeInfo = book.volumeInfo;
    resultsHTML +=
      <div>
        <h3>${volumeInfo.title}</h3>
        <p>${volumeInfo.authors.join(', ')}</p>
        <p>${volumeInfo.description}</p>
        <a href="${volumeInfo.infoLink}">詳細</a>
        <img src="${volumeInfo.imageLinks.smallThumbnail}"></img>
      </div>
      ;
  }
  document.getElementById('results').innerHTML = resultsHTML;

  //検索履歴を更新
  loadHistory();
});

async function loadHistory(){
  const response = await fetch('get_history.php');
  const history = await response.json();

  // //仮のデータ
  // const history = [
  //   {id:1, search_query: 'Javascript', search_date: '2023-05-09 12:00:00'},
  //   {id:2, search_query: 'PHP', search_date: '2023-05-09 13:00:00'}
  // ];

  let historyHTML = '<ul>';
  for(const item of history){
    historyHTML += '<li data-id="${item.id}">${item.search_query}(${item.search_date})</li>'
  }
  historyHTML += '</ul>';
  document.getElementById('history').innerHTML = historyHTML;

  //検索履歴のクリックイベント
  document.querySelectorAll('#history li').forEach((li)=>{
    li.addEventListener('click', async(event)=>{
      const searchId = event.target.dataset.id;

      const response = await fetch('get_results.php?id=' + searchId);
      const results = await response.json();

      // //仮のデータ
      // const results = [
      //   {title: 'JavaScript入門', authors: ['John Doe'], description: 'Javascriotの基本を学ぶ', info_link: '#', small_thumbnail: 'demo.png' },
      //   {title: 'PHP入門', authors: ['John Doe'], description: 'PHPの基本を学ぶ', info_link: '#', small_thumbnail: 'demo.png' }
      // ]

      let resultsHTML = "";
      for(const result of results){
        resultsHTML +=  
        <div>
          <h3>${result.title}</h3>
          <p>${result.authors.join(', ')}</p>
          <p>${result.description}</p>
          <a href="${result.info_link}">詳細</a>
          <img src="${result.small_thumbnail}"></img>
        </div> 
      }
      document.getElementById('results').innerHTML = resultsHTML;
    });
  })
}