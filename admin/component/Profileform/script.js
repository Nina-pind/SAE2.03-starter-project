let templateFile = await fetch("./component/Profileform/template.html");
let template = await templateFile.text();

let ProfileForm = {};

ProfileForm.format = function (profiles, handler) {
  let html = template;

  // Crée les <option> pour chaque profil
  let options = profiles.map((p) =>
    `<option value="${p.id}" data-name="${p.name}" data-avatar="${p.avatar}" data-age="${p.min_age}">${p.name}</option>`
  ).join("");

  // Remplace les placeholders dans le template
  html = html.replace("{{options}}", options);
  html = html.replace("{{handler}}", handler); // Remplace {{handler}} par la fonction passée

  return html;
};

ProfileForm.init = function () {
  let select = document.getElementById("profile__select");
  const idField = document.getElementById("profile-id"); // Champ caché pour l'ID
  let nameField = document.getElementById("profile-name");
  let avatarField = document.getElementById("profile-avatar");
  let minAgeField = document.getElementById("profile-age-restriction");
  let submitBtn = document.getElementById("profile-submit-btn");

  // Remplit les champs lorsque l'utilisateur sélectionne un profil
  select.addEventListener("change", () => {
    let option = select.selectedOptions[0];
    nameField.value = option.dataset.name || "";
    avatarField.value = option.dataset.avatar || "";
    minAgeField.value = option.dataset.age || "";
    console.log("Profil sélectionné :", {
      id: select.value,
      name: nameField.value,
      avatar: avatarField.value,
      min_age: minAgeField.value,
    });
  });

  submitBtn.addEventListener("click", async () => {
    let id = select.value; // Récupère l'ID du profil sélectionné
    let name = nameField.value;
    let avatar = avatarField.value;
    let min_age = minAgeField.value;
  
    let formData = new FormData();
    formData.append("name", name);
    formData.append("avatar", avatar);
    formData.append("min_age", min_age);
  
    let url = "../server/script.php?todo=";
    if (id && id !== "") {
      // Modification d'un profil
      formData.append("id", id);
      url += "updateProfile";
    } else {
      // Ajout d'un nouveau profil
      url += "addProfile";
    }
  
    console.log("Données envoyées :", { id, name, avatar, min_age });
  
  });
};

export { ProfileForm };