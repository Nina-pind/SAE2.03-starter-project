let templateFile = await fetch ('./component/Itération1/template.html');
let template = await templateFile.txt();

let Itération1 = {};


Films.format =  function(obj) {
  let html = template;
  html = html.replace('{{film}}', obj.film);
  html = html.replace('{{image}}', obj.urlImage);
  return html;
}

export { Itération1 };
