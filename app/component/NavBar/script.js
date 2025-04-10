let navBarTemplateFile = await fetch("./component/NavBar/template.html");
let navBarTemplate = await navBarTemplateFile.text();

let NavBar = {};

NavBar.format = function (hAbout, hHome, profiles) {
  let html = navBarTemplate;
  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);

  // Générer les options pour les profils
  let profileOptions = "";
  for (let i = 0; i < profiles.length; i++) {
    let profile = profiles[i];
    profileOptions += `<option value="${profile.id}" data-img="${profile.avatar}" data-age="${profile.min_age}">${profile.name}</option>`;
  }

  html = html.replace("{{profileOptions}}", profileOptions);

  // Utiliser l'image du premier profil ou une image par défaut
  let image = profiles[0]?.avatar || "default-avatar.jpg";
  html = html.replace("{{image}}", image);

  return html;
};

export { NavBar };
