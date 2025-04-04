let templateFile = await fetch("./component/filmform/template.html");
let template = await templateFile.text();

let FilmsForm = {};

FilmsForm.format = function (handler) {
  let html = template;
  html = html.replace("{{handler}}", handler);
  return html;
};

export { FilmsForm };