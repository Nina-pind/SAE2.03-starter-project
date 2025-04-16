import { DataProfile } from "../../data/dataProfile.js";

let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = async function (hAbout, hHome) {
  let html = template;

  // Récupération des profils via DataProfile
  const profiles = await DataProfile.readProfile();
  console.log("Profils récupérés :", profiles);

  let profileOptions = "";
  for (let i = 0; i < profiles.length; i++) {
    const profile = profiles[i];
    profileOptions += `<option value="${profile.id}" data-img="${profile.avatar}" data-age="${profile.min_age}">${profile.name}</option>`;
  }

// Définir le premier profil comme sélectionné par défaut

if (profiles.length > 0) {
  C.currentProfile = profiles[0];
  C.activeProfileId = profiles[0].id;
  C.getAllMovies(); 
}



  html = html.replace("{{hAbout}}", hAbout);
  html = html.replace("{{hHome}}", hHome);
  html = html.replace("{{profileOptions}}", profileOptions);

  let image = profiles[0]?.avatar || "default-avatar.jpg";
  html = html.replace("{{image}}", image);

  return html;
};

export { NavBar };