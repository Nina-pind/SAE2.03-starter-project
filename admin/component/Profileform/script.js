let templateFile = await fetch("./component/Profileform/template.html");
let template = await templateFile.text();

let ProfileForm = {};

// Génère le HTML avec le handler pour la soumission
ProfileForm.format = function (handler) {
  let html = template;
  html = html.replace("{{handler}}", handler); // Remplace {{handler}} par la fonction de gestion
  return html;
};



export { ProfileForm };