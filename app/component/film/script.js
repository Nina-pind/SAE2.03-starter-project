// Chargement des templates HTML
let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/film/template_li.html");
let templateLi = await templateLiFile.text();

let Films = {};


Films.format = function (films, profile_id, favorites = []) {
  let html = "";
  favorites = Array.isArray(favorites) ? favorites : [];

  films.forEach((film) => {
    let filmHtml = template;
    filmHtml = filmHtml.replace("{{titre}}", film.name);
    filmHtml = filmHtml.replace("{{image}}", film.image);
    filmHtml = filmHtml.replace("{{handler}}", `C.handlerTrailer(${film.id})`);

    let isFavorite = favorites.some((fav) => fav.id === film.id);

const favoriteButton = isFavorite
  ? `<button class="favorite-btn disabled"><i class="fas fa-heart"></i> Favori</button>`  // Cœur rempli
  : `<button onclick="C.addFavorite(${film.id})" class="favorite-btn"><i class="far fa-heart"></i> Ajouter aux favoris</button>`; 

    filmHtml = filmHtml.replace("{{favorite}}", favoriteButton);

    // Ajouter l'eventListener pour chaque bouton
    const btn = document.getElementById(`favorite-btn-${film.id}`);
    if (btn) {
      btn.addEventListener("click", () => {
        C.addFavorite(profile_id, film.id);
      });
    }

    html += filmHtml;
  });

  return html;
};



Films.formatLi = function (films, profile_id, favorites = []) {
  let filmContent = Films.format(films, profile_id, favorites); // Génère le HTML des films
  let liHtml = templateLi;
  liHtml = liHtml.replace("{{film}}", filmContent); // Insère les films dans le conteneur
  return liHtml;
};

export { Films };