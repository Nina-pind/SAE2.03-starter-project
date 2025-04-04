let templateFile = await fetch("./component/filmform/template.html");
let template = await templateFile.text();

let FilmsForm = {};

FilmsForm.format = function (obj) {
  let html = template;
  html = html.replace("{{id}}", obj.id);
  return html;
};

export { FilmsForm };