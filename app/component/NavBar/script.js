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
      return `<option value="${profile.id}">${profile.name}</option>`;
    })
    .join("");

  // Générer le menu déroulant des profils
  let profileSelect = `
  <select id="profile-select" onchange="changeProfile(event)">
    <option disabled selected>Choisir un profil</option>
    ${profileOptions}
  </select>
`;

  html = html.replace("{{profileSelect}}", profileSelect);

  return html;
};

export { NavBar };