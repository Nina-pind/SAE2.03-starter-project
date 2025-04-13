let templateFile = await fetch("./component/moderateComments/template.html");
let template = await templateFile.text();

let ModerateComments = {};

ModerateComments.format = function (comments, approveHandler, deleteHandler) {
  let html = template;

  if (comments.length === 0) {
    html = html.replace(
      "{{comments}}",
      "<li>Aucun commentaire à modérer pour le moment.</li>"
    );
  } else {
    let commentsHtml = comments
      .map(
        (comment) => `
        <li class="moderateComments__item">
          <p><strong>${comment.profile_name}</strong> (${comment.created_at}):</p>
          <p>${comment.comment}</p>
          <button onclick="${approveHandler}(${comment.id})">Approuver</button>
          <button onclick="${deleteHandler}(${comment.id})">Supprimer</button>
        </li>
      `
      )
      .join("");
    html = html.replace("{{comments}}", commentsHtml);
  }

  return html;
};

export { ModerateComments };