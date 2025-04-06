let templateFile = await fetch("./component/profileform/template.html"); // Charge le template HTML du formulaire
let template = await templateFile.text();

let ProfileForm = {};

// Génère le HTML avec le handler pour la soumission
ProfileForm.format = function (handler) {
  let html = template;
  html = html.replace("{{handler}}", handler); // Remplace {{handler}} par la fonction de gestion
  return html;
};

// Gestionnaire de soumission du formulaire
ProfileForm.handleSubmit = async function (event) {
  event.preventDefault(); // Empêche le comportement par défaut (rechargement de la page)

  // Récupère les valeurs du formulaire
  let name = document.getElementById("profile-name").value;
  let avatar = document.getElementById("profile-avatar").value || null;  // Avatar facultatif
  let ageRestriction = document.getElementById("profile-age-restriction").value || 0; // Par défaut à 0

  // Envoie la requête pour ajouter le profil
  let response = await fetch("/path/to/your/script.php?todo=addProfile", {
    method: "POST",
    body: JSON.stringify({ name, avatar, ageRestriction }),
    headers: {
      "Content-Type": "application/json"
    }
  });

  let data = await response.json();

  // Affiche un message en fonction de la réponse du serveur
  if (data.success) {
    alert("Le profil a été ajouté avec succès !");
  } else {
    alert("Erreur lors de l'ajout du profil.");
  }
};

export { ProfileForm };