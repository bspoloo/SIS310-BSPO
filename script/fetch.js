function changeContent(page,titulo){

    console.log(titulo);
    document.getElementById("titulo").innerHTML = titulo;

    let content = document.getElementById('content');
    fetch(page)
        .then(response => response.text())
        .then(data => content.innerHTML = data);
}