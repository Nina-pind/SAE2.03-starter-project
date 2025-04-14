let HOST_URL = "../server";

let DataProfile = {}; 

// Ajoute un profil au serveur
DataProfile.addProfile = async function (fdata) {
  let config = {
    method: "POST", // Méthode HTTP à utiliser
    body: fdata,    // Données à envoyer sous forme d'objet FormData
  };

  // Envoie la requête HTTP
  let answer = await fetch(`${HOST_URL}/script.php?todo=addProfile`, config);

  // Vérifie si la réponse est correcte (status 200-299)
  if (!answer.ok) {
    console.error("Erreur HTTP:", answer.status);
    let text = await answer.text();
    console.error("Réponse brute :", text);
    return { success: false, error: `Erreur serveur (${answer.status})` };
  }

  // Tente de parser la réponse JSON
  let data = await answer.json();
  return data;
};

// Met à jour un profil sur le serveur
DataProfile.updateProfile = async function (fdata) {
  let config = {
    method: "POST", // Méthode HTTP à utiliser
    body: fdata,    // Données à envoyer sous forme d'objet FormData
  };

  let answer = await fetch(`${HOST_URL}/script.php?todo=updateProfiles`, config);

  // Tente de parser la réponse JSON
  let data = await answer.json();
  return data;
};

// Lit les profils du serveur
DataProfile.readProfile = async function () {
  let answer = await fetch(`${HOST_URL}/script.php?todo=readProfiles`);

  // Tente de parser la réponse JSON
  let profile = await answer.json();
  return profile;
};

export { DataProfile };
