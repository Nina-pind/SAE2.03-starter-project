let templateFile = await fetch("./component/film/template.html");
let template = await templateFile.text();

let templateLiFile = await fetch("./component/film/template_li.html");
let templateLi = await templateLiFile.text();

let Films = {};

// Formate les films avec le template principal
Films.format = function (films, profileId, favorites = []) {
  let filmHtml = "";

  if (!favorites || !Array.isArray(favorites)) {
    favorites = [];
  }

  for (let movie of films) {
    let templateCopy = template; // Crée une copie du template pour chaque film
    templateCopy = templateCopy.replace("{{titre}}", movie.name);
    templateCopy = templateCopy.replace("{{image}}", movie.image);
    templateCopy = templateCopy.replace("{{handler}}", `C.handlerTrailer(${movie.id})`);

    // Vérifie si le film est récent (ajouté dans les 7 derniers jours)
    const isRecent = new Date(movie.created_at) >= new Date(Date.now() - 7 * 24 * 60 * 60 * 1000);
    const newTag = isRecent ? '<span class="tag-new">New</span>' : '';
    templateCopy = templateCopy.replace("{{newTag}}", newTag);

    let isFavorite = favorites.some(fav => fav.id === movie.id);

    // Ajoute un bouton "Ajouter aux favoris" ou "Favoris" désactivé
    const favoriteButton = isFavorite
      ? `<button disabled>Favoris</button>`
      : `<button class="add-to-favorites-button" onclick="C.addFavorites(${movie.id}, ${profileId})">Ajouter aux favoris</button>`;

    templateCopy = templateCopy.replace("{{button}}", favoriteButton);

    filmHtml += templateCopy; // Ajoute le HTML du film au contenu global
  }

  return filmHtml;
};

// Insère les films formatés dans le conteneur défini par template_li
Films.formatLi = function (films, profileId, favorites) {
  let filmContent = Films.format(films, profileId, favorites); // Génère le HTML des films
  let liHtml = templateLi;
  liHtml = liHtml.replace("{{film}}", filmContent); // Insère les films dans le conteneur
  return liHtml;
};

export { Films };