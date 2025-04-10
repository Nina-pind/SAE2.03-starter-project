let MovieSearch = {};

MovieSearch.init = function () {
  document.querySelector("#searchKeyword").addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      C.handlerSearchMovies();
    }
  });
};

MovieSearch.formatResults = function (movies, updateHandler) {
  if (movies.length === 0) {
    return `<p>Aucun film ne correspond à votre recherche.</p>`;
  }

  let html = "";
  let i = 0;
  let moviesCount = movies.length;

  while (i < moviesCount) {
    let movie = movies[i];
    html += `
      <form class="movieSearch__card">
        <h3>${movie.name}</h3>
        <p>Catégorie : ${movie.category || "Non spécifiée"}</p>
        <p>Mis en avant : ${movie.is_featured ? "Oui" : "Non"}</p>
        <button type="button" onclick="${updateHandler}(${movie.id}, ${!movie.is_featured})">
          ${movie.is_featured ? "Retirer" : "Mettre en avant"}
        </button>
      </form>
    `;
    i++;
  }

  return html;
};

export { MovieSearch };
