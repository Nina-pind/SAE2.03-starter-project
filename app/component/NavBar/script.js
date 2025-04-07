import { DataProfile} from "../../data/dataProfile.js";

let navBarTemplateFile = await fetch("./component/NavBar/template.html");
let navBarTemplate = await navBarTemplateFile.text();

let NavBar = {};

NavBar.format = async function (hAbout, hHome) {
  let html = navBarTemplate;

  const profiles = await DataProfile.read();


  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);
  let image = profiles [0]?.avatar||"";
  html = html.replace("{{image}}", image);

  // Générer les options pour les profils
  let profileSelect = profiles
    .map(profile => {
      return `<option value="${profile.id}" data-img="${profile.avatar}" data-age="${profile.min_age}">${profile.name}</option>`;
    })
    .join("");


  html = html.replace("{{profileSelect}}", profileSelect);

  return html;
};

export { NavBar };