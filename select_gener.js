var top_bar_select_genre = document.getElementById("select_genre");
var genreContainer = document.getElementById("genreContainer");

function hidegenreContainer() {
    genreContainer.style.display = "none";
}

top_bar_select_genre.addEventListener("click", function() {
    genreContainer.style.display = "block";
    genreContainer.style.position = "absolute";
    genreContainer.style.marginTop = "24px";
    genreContainer.style.backgroundColor = "white";
});

document.addEventListener("click", function(event) {
    var target = event.target;
    if (target !== top_bar_select_genre && !genreContainer.contains(target)) {
        hidegenreContainer();
    }
});