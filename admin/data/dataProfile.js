let HOST_URL = "https://mmi.unilim.fr/~pinardel2/SAE2.03-Pinardel";

let DataProfile = {}; 
DataProfile.addProfile = async function (fdata) {
  let config = {
    method: "POST",
    body: fdata,
  };

  let answer = await fetch(HOST_URL + "/server/script.php?todo=addProfile", config);
  let data = await answer.json();
  console.log("Réponse du serveur :", data);
  
  if (!data) {
    console.error("Erreur : Aucune réponse reçue du serveur pour l'ajout du profil.");
    return "Erreur lors de l'ajout du profil.";
  }
  
  return data; // Assure-toi que `data` contient une réponse valide du serveur
};

DataProfile.updateProfile = async function (fdata) {
  let config = {
    method: "POST",
    body: fdata,
  };

  let answer = await fetch(HOST_URL + "/server/script.php?todo=addProfile", config);
  let data = await answer.json();
  console.log("Réponse du serveur :", data);
  
  if (!data) {
    console.error("Erreur : Aucune réponse reçue du serveur pour la mise à jour du profil.");
    return "Erreur lors de la mise à jour du profil.";
  }

  return data; // Assure-toi que `data` contient une réponse valide du serveur
};

DataProfile.getProfiles = async function () {
  let answer = await fetch(HOST_URL + "/server/script.php?todo=readProfiles");
  let profiles = await answer.json();
  console.log("Profiles fetched:", profiles); // Vérifiez les données ici
  return profiles;
};

export { DataProfile };
