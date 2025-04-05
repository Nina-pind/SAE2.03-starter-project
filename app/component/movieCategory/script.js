import { Films } from "../film/script.js";

let templateFile = await fetch("./component/movieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (category) {
    let categoryHtml = template;
    categoryHtml = categoryHtml.replace("{{categoryName}}", category.name);

    // Ensure category.movies is passed to Movie.format
    let moviesListHtml = Films.format(category.movies || []);
    categoryHtml = categoryHtml.replace("{{moviesList}}", moviesListHtml);

    return categoryHtml;
};

export { MovieCategory };