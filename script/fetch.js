function changeContent(page){
    let content = document.getElementById('content');
    fetch(page)
        .then(response => response.text())
        .then(data => content.innerHTML = data);
}
