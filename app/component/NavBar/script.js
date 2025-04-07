let navBarTemplateFile = await fetch("./component/NavBar/template.html");
let navBarTemplate = await navBarTemplateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, hHome, profiles) {
  let html = navBarTemplate;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);
  let image = profiles [0]?.avatar||"";
  html = html.replace("{{image}}", image);

  // Générer les options pour les profils
  let profileOptions = profiles
    .map(profile => {
      return `<option value="${profile.id}"data-img="${profile.avatar}" data-age="${profile.min_age}">${profile.name}</option>`;
    })
    .join("");
  

    html = html.replace("{{profileOptions}}", profileOptions);

  return html;
};

export { NavBar };