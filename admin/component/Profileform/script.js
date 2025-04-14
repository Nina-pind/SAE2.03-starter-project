import { DataProfile } from "../../data/dataProfile.js";

let templateFile = await fetch("./component/Profileform/template.html");
let template = await templateFile.text();

let ProfileForm = {};

// Génère le HTML avec les options de profil et le handler pour la soumission
ProfileForm.format = function (profiles, handler) {
    let html = template;
    let options = "";
    
    // Génère les options de profil dans le menu déroulant
    for (let i = 0; i < profiles.length; i++) {
        const p = profiles[i];
        options += `<option value="${p.id}" data-name="${p.name}" data-avatar="${p.avatar}" data-age="${p.min_age}">${p.name}</option>`;
    }

    html = html.replace("{{options}}", options);  // Remplace {{options}} par les options générées
    html = html.replace("{{handler}}", handler);  // Remplace {{handler}} par le handler
    return html;
};

// Initialise les champs du formulaire en fonction du profil sélectionné
ProfileForm.init = function () {
    const select = document.getElementById("addprofile__select");
    const nameField = document.getElementById("profile-name");
    const avatarField = document.getElementById("profile-avatar");
    const minAgeField = document.getElementById("profile-age-restriction");

    // Remplit les champs en fonction du profil sélectionné
    select.addEventListener("change", (event) => {
        const selectedOption = event.target.selectedOptions[0];
        if (selectedOption) {
            nameField.value = selectedOption.dataset.name || "";
            avatarField.value = selectedOption.dataset.avatar || "";
            minAgeField.value = selectedOption.dataset.age || "";
        }
    });
};

export { ProfileForm };
