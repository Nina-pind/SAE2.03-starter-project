let templateFile = await fetch("./component/movieComment/template.html");
let template = await templateFile.text();

let MovieComment = {};

MovieComment.format = function (movieId, comments) {
  let html = template;

  // Remplacement des commentaires
  let commentsHtml = "";
  if (comments.message) {
    commentsHtml = `<p>${comments.message}</p>`;
  } else {
    commentsHtml = "<ul>";
    comments.forEach(comment => {
      commentsHtml += `
        <li>
          <strong>${comment.profile_name}</strong> 
          <span class="comment-date">(${comment.created_at})</span>: 
          <p>${comment.comment}</p>
        </li>`;
    });
    commentsHtml += "</ul>";
  }

  html = html.replace("{{commentsList}}", commentsHtml);

  // Ajout du champ de saisie et du bouton
  html = html.replace("{{textareaId}}", `comment-input-${movieId}`);
  html = html.replace("{{onclick}}", `C.addComment(${movieId})`);

  return html;
};

export { MovieComment };