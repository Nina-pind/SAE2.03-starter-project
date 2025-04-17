import { DataProfile } from "../../data/dataProfile.js";

let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = async function (hAbout, hHome) {
  let html = template;

  const profiles = await DataProfile.readProfile();
  console.log("Profils récupérés :", profiles);

  let profileOptions = profiles.map(profile => `
    <option value="${profile.id}" data-img="${profile.avatar}" data-age="${profile.min_age}">
      ${profile.name}
    </option>
  `).join("");

  if (profiles.length > 0) {
    C.currentProfile = profiles[0];
    C.activeProfileId = profiles[0].id;
    C.getAllMovies();
  }

  html = html.replace(/{{hAbout}}/g, hAbout);
  html = html.replace(/{{hHome}}/g, hHome);
  html = html.replace(/{{profileOptions}}/g, profileOptions);

  const image = profiles[0]?.avatar || "default-avatar.jpg";
  html = html.replace("{{image}}", image);

  return html;
};

NavBar.initListeners = function () {
  const burger = document.querySelector('.burger');
  const mobileNav = document.querySelector("#mobileNavDropdown");

  if (!burger || !mobileNav) {
    console.warn("Burger ou mobileNav introuvable !");
    return;
  }

  burger.addEventListener('click', () => {
    console.log("Burger cliqué !");
    mobileNav.classList.toggle('hidden');
  });
};


export { NavBar };
